# Uitleg bij property api demo

## data model

in `data_model_property.md` staan de properties zoals ik ze in de database voor me zie.

## API spec

in `openapi_spec_property.json` staan de 2 endpoints en de json data structuur van `Property`
de endpoints `GET:/api/property/` voor een lijst van allen properties en `POST:/api/property/` voor toevoegen van property zijn beschreven

## API implementatie

in `api/properties.php` is en voorbeeld implementatie van het endpoint gemaakt, nog zonder gebruik van de database.

## Testing

met [postman](https://www.postman.com/) is het mogelijk om de endpoints te testen. Zie de video `api_demo.webm`.