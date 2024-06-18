import pymysql
from datetime import datetime, timedelta

# Conexión a la base de datos
db = pymysql.connect(
    host="localhost",
    user="root",
    password="",
    database="aulainteligente"
)

def get_current_schedule():
    cursor = db.cursor(pymysql.cursors.DictCursor)
    now = datetime.now()
    dia = now.weekday()  # MySQL tiene los días de la semana de 1 a 7
    hora_actual = now.time()

    query = """
    SELECT h.id, h.materia, h.grupo, h.horaInicio, t.minutos AS tolerancia
    FROM Horarios h
    JOIN Tolerancia t ON h.materia = t.materia
    WHERE h.dia = %s AND h.horaInicio <= %s AND h.horaFin >= %s
    """
    cursor.execute(query, (dia, hora_actual, hora_actual))
    return cursor.fetchone()

def verify_student_registration(carnet):
    cursor = db.cursor()
    query = "SELECT id FROM Alumnos WHERE carnet = %s"
    cursor.execute(query, (carnet,))
    return cursor.fetchone()

def verify_student_enrollment(student_id, materia, grupo):
    cursor = db.cursor()
    query = """
    SELECT id FROM MateriasInscritas
    WHERE alumno = %s AND materia = %s AND grupo = %s
    """
    cursor.execute(query, (student_id, materia, grupo))
    return cursor.fetchone()

def register_initial_attendance(materia, grupo):
    cursor = db.cursor()
    now = datetime.now()
    today = now.date()
    query = """
    INSERT INTO Asistencias (fechaHora, materia, alumno, grupo, estado)
    SELECT %s, %s, mi.alumno, %s, 'I'
    FROM MateriasInscritas mi
    LEFT JOIN Asistencias a ON mi.alumno = a.alumno AND mi.materia = a.materia AND DATE(a.fechaHora) = %s
    WHERE mi.materia = %s AND mi.grupo = %s AND a.id IS NULL
    """
    cursor.execute(query, (now, materia, grupo, today, materia, grupo))
    db.commit()

def update_attendance_state(student_id, materia, grupo, estado):
    cursor = db.cursor()
    now = datetime.now()
    query = """
    UPDATE Asistencias
    SET estado = %s, fechaHora = %s
    WHERE alumno = %s AND materia = %s AND grupo = %s AND estado = 'I'
    """
    cursor.execute(query, (estado, now, student_id, materia, grupo))
    db.commit()

def main(carnet):
    schedule = get_current_schedule()
    if not schedule:
        print("No hay clases en este momento.")
        return

    materia = schedule['materia']
    grupo = schedule['grupo']
    tolerancia = schedule['tolerancia']

    # Registrar la asistencia inicial de todos los estudiantes con estado 'I'
    register_initial_attendance(materia, grupo)
    print(f"Asistencia inicial registrada para todos los estudiantes en la materia {materia} y grupo {grupo} con estado 'I'.")

    student = verify_student_registration(carnet)
    if not student:
        print("Estudiante no registrado.")
        return

    student_id = student[0]  # Acceder al primer elemento de la tupla

    enrollment = verify_student_enrollment(student_id, materia, grupo)
    if not enrollment:
        print("Estudiante no está inscrito en la materia o grupo correspondiente.")
        return

    now = datetime.now()
    hora_inicio = schedule['horaInicio']
    if isinstance(hora_inicio, timedelta):
        hora_inicio = (datetime.min + hora_inicio).time()
    start_time = datetime.combine(now.date(), hora_inicio)
    late_time = start_time + timedelta(minutes=tolerancia)
    
    if now > late_time:
        estado = 'T'
    else:
        estado = '•'

    update_attendance_state(student_id, materia, grupo, estado)
    print(f"Asistencia registrada para el estudiante {carnet} con estado {estado}.")

if __name__ == "__main__":
    carnet = input("Ingrese el carnet del estudiante: ")
    main(carnet)