#!/usr/bin/env python
"""Very simple script used to generate SQL to create and populate
dolores_locations table.

Usage: gen_locations_sql.py | mysql -h <host> -u <user> -p<pass> <db_name>
"""

import os

pwd = os.path.dirname(os.path.realpath(__file__))
data_dir = os.path.join(pwd, "../static/data/locations")

print("DROP TABLE IF EXISTS dolores_locations;")

print("""CREATE TABLE dolores_locations (
  id INTEGER auto_increment NOT NULL PRIMARY KEY,
  name VARCHAR(255),
  latitude DECIMAL(13, 10),
  longitude DECIMAL(13, 10)
) COLLATE utf8mb4_unicode_ci;""")

locations = []
for name in os.listdir(data_dir):
  path = os.path.join(data_dir, name)
  with open(path, "r") as f:
    for line in f:
      place, latitude, longitude = line.strip().split(',')
      locations.append("('%s', '%s', '%s')" % (place, latitude, longitude))

insert = "INSERT INTO dolores_locations (name, latitude, longitude) VALUES %s;"
data = ", ".join(locations)
print(insert % data)
