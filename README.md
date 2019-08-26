# Info
`docker-compose up` per l'esecuzione dell'ambiente locale di *SOS*.
Lo stack comprende un container `web`, contenente `php7.2`, `nginx`, `joomla` e `simpleSAMLphp`, e un `db` mysql.
# Istruzioni
- `cp .env.template .env` (ed eventuale modifica delle variabili d'ambiente)
- avviare l'ambiente di sviluppo con `npm run start`

# Note
Il container di sviluppo risponde a `localhost:8000`
Le credenziali di amministratore (`localhost:8000/administrator`) dell'ambiente locale sono:
- user: `admin`
- password: `admin`
