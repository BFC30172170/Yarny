# [YARNY](https://github.com/BFC30172170/Yarny) 

Yarny is a template php website created for a full-stack Responsive site project assigned at Blackpool & The Fylde College (B&FC)

## Installation

Clone this repository

Use the cross-platform development environment [xampp](https://www.apachefriends.org/) to create a server using apache, mysql, & php.

alter the httpd.conf file to set the document root and directory to the public folder of this project 

```httpd.conf
DocumentRoot "C:/path/to/xampp/htdocs/yarny"
<Directory "C:/path/to/xampp/htdocs/yarny/public">
```

## Credentials

Sample credentials to explore the site as an admin or user are found below in the format USERNAME:PASSWORD

> admin:password  
> user:password

## Walkthrough
While the use of the website as a register or unregistered user is self-explanatory. It is worth noting that access to admin tools via the above admin user can be found by following the below instructions:
1. Login via the login page accessed by the top right navigation item, supplying the admin username password
2. Navigate to the account menu by clicking on your user name in the top right navigation item.
3. Underneath the main 'Your Account' Heading, click the link to 'Go To Admin Centre'.
4. While Products, Tags, & Categories are fully customisable within the admin centre; other functionality outside the scope of this project such as account & review management is read only

## Design Changes
While it is the hope of this project to complete the entire design, there are some components outside of the assignment brief that have not been completed in the interest of time. See these listed as below

1. Category Counts - Within the Product Page, The number of items associated with each category or tag choice are not listed as scoped in the design document. This is a small UI improvement but is not of any major importance for the project.
2. Contact Settings - Within the account pages, options for contact and notification settings are not present.
3. UI Tweaks - There are some tweaks through the site that have been made to the user interface for the interest of time. None of these change the overall look and feel of the site, but have been made to prioritise key features.



