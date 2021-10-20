# Location and Distance #


## URL ##

  {host}/Api/index.php/{model}/{action}

## Method: ##

  `GET` | `POST` | `DELETE` | `PUT`
  
# URL Params #

## Location Model ##

/location/
###   ACTIONS: ###

**read** - read adresses from database (only GET method) 
available params:

- `limit` (default `limit=10`)
- `id` - optional, return record where record id = `id`
_______________
*sample*

request: `{host}/index.php/location/read?id=4`

responce: `[{"id":"4","street":"Cyfrowa","building_no":"8","postal_code":"","city":"Szczecin","country":"Polska","created":"2021-10-18 22:20:17"}]`

request: `{host}/index.php/location/read?limit=2`

responce: `[{"id":"1","street":"Pawia","building_no":"9","postal_code":"31-154","city":"Krakow","country":"Polska","created":"2021-10-18 10:28:34"},{"id":"4","street":"Cyfrowa","building_no":"8","postal_code":"","city":"Szczecin","country":"Polska","created":"2021-10-18 22:20:17"}]`

___________
**create** - create new record in address database (only POST method)-`street` and `city` are required. Sample of request body:

        {"street": "Kościuszki","building_no": "54", "postal_code":"10-504", "city": "Olsztyn", "country": "Polska"}


**update** - update record (only PUT method) - `id`, `street` and `city` are required. Sample of request body:

        `{"id":"7","street": "Kościuszki","building_no": "54", "postal_code":"10-504", "city": "Olsztyn", "country": "Polska"} 
    
**delete** - delete record if exist (only DELETE method) - `id` is required.

## Distance Model ##

/distance/
###   ACTIONS: ###  
   
**distance** - return distance beetween params  (only GET method) 
params (both required):

- `from` - string with address or integer
- `to` - string with address or integer
  
if param is integer then address is fetch from database where integer is record id

### Attention ###
- address string without national chars
- address string quoted by ' {string} ' or spaces replaced by + 
_______________
*sample*

request: `{host}/index.php/distance/distance?from=4&to='Jaskowa Dolina 7 Gdansk Polska'`

responce: `{"distance":370.001}`
___________
## Notes: ##
If responce: `{"distance":0}` then propably Api_key expired. Api key value in `config.php`

## To Do ##
- refactor `LocationControler.php` - some parts of code recurs
- implement better Error handling