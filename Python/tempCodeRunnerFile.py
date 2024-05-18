from datetime import datetime, timedelta

# La hora obtenida de la base de datos
hora_db = "13:00:00"

# Convertir la cadena a un objeto datetime (asumiendo una fecha arbitraria)
fecha_hora = datetime.strptime(hora_db, "%H:%M:%S")

# Sumar 10 minutos
fecha_hora_modificada = fecha_hora + timedelta(minutes=10)

# Extraer la nueva hora
nueva_hora = fecha_hora_modificada.time()

print("Hora original:", hora_db)
print("Nueva hora:", nueva_hora)
