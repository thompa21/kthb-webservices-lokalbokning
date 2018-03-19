# Lokalbokning API Version 1
Api mot KTH Bibliotekets system för lokalbokning.

## Funktioner
### Används för applikation som hämtar bokningar att ladda ner i csv-format
https://apps.lib.kth.se/lokalbokning/

### Anrop till Api kräver JWT-token för autentisering(erhålls via login mot KTH), eller api_key

#### JWT
https://apps.lib.kth.se/webservices/lokalbokning/api/v1/events?token={jwttoken}&fromDate=2018-03-06&toDate=2018-03-06&limit=none

#### API_KEY
https://apps.lib.kth.se/webservices/lokalbokning/api/v1/events?api_key={apikey}&fromDate=2018-03-06&toDate=2018-03-06&limit=none
