# AddressValidation
AddressValidation for Magento 2

Introduction
------------
The goal is to make an extension that can both lookup and validate customer addresses.
This extension should solve the problem that orders are shipped to non-existing addresses.
The extension will be a bridge between various address lookup services and magento.

Approach
--------
- We make the assumption that an address must be valid, once we get an address from the lookup.
- We do not use a special "house number" address attribute but make usage of the different address lines (configurable).

Address lookup service interface parameters
-------------------------------------------
Fields needed for looking up address (multiselect)
- Country (always needed)
- State (optional)
- Address (optional
- House number (optional)
- Postcode (optional)

List of countries that are allowed/supported by the service (multiselect)

Is the user allowed to order without a valid address (dropdown)
- No (not allowed to order)
- Yes (enter address manually)

Address Validation (and formatting)
-----------------------------------
Optional reg-ex validation can be added for the following fields
- Address
- House number
- Postcode
Optional there could be autocorrection (like removing or adding spaces from dutch postcodes etc)

Backend configuration
---------------------
In the admin, per country you can enable "lookup/validation" by setting the following parameters.
- An "address lookup service" (services are configured individually)
- Configuration for which of the address fields is the house number and which is the streetname
- An address validator

Workflow frontend
=================
- Customer enters address (in checkout)
- When necessary fields are entered (Depending on the adapter) the form will silently submit itself to a controller 
- The controller will return one of:
-- A single address > we use this as a valid address
-- A list of possible addresses > user must select one of the addresses or choose to set an address manually
-- No address > enter address manually or do not order (depending on setting)

Workflow backend
================
- An address that is submitted for lookup will be validated before looking up according to the validator
- It the address is valid a lookup will be done
- An address (both from a service, or entered manually) that is submitted as "quote address" will be validated according 
to the validator

List of possible services
=========================
- http://api.postcode.nl
- http://www.pcapredict.com/en-us/index/
- http://www.webservices.nl/product/adressen-internationaal/
- https://www.ups.com/content/nl/en/bussol/browse/online_tools_us_address_validation.html
- http://www.d-centralize.nl/projects/pro6pp
