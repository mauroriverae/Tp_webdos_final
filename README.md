# API REST ENDPOINT’S

GET /company
Access the list of companies
  add query params to get request:
    /company?order?&sort?
    /company?filter=?&column=?&sort=?
    /company?filter
    /company?column=?&search=?
    #Restricts:
      Filter= Tecnologia, Servicios de comunicacion, Materiales Basicos, Energia, Servicios financieros, Industriales, Consumo discrecional
      Sort= ASC or DESC
      Order = Tiker, Sector, Company
      Column = Tiker, Sector, Company, id

POST /company
added a new company

GET /company/:id(ej /company/123)
Access the detail of a company
  Restrict= Only numeric

PUT /company/:id (ej /company/123)
Edit the company, replacing the information sent

DELETE /company/:id (ej /company/55)
Delete company
