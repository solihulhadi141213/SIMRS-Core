# SIMRS CORE V 3.0.0 (Beta) #

SIMRS Core V3 is an improvement over the previous version, SIMRS V2.
This version features significant changes and a different way of working.
SIMRS Core V3 is a hospital management information system integrated with electronic medical records. The application is built on a microservice basis, enabling other applications to communicate with the central SIMRS database. Patient medical information is written using FHIR. An API service is available for easier application development.

### System Specifications ###

* PHP 8.x
* MySql 9.1.0
* Apache 2.4.62.1

### Dependencies ###

* Bootstrap 5.3.8
* Jquery 4.0.0
* jquery-ui-1.14.2
* sweetalert2 ^11.26.24
* tinymce ^8.3.2
* themify-icons
* icofont
* font-awesome
* apexcharts ^5.10.4
* bootstrap-icons ^1.13.1


### Module ###

* Dashboard
* Aksesibilitas
* Monitoring
* Pengaturan
* Referensi

### Database ###
```json
[
    {
        "table_name" : "akses",
        "column" : [
            {
                "column_name" : "id_akses",
                "type" : "",
                "column_name" : "",
            }
        ]
    }
]
```
* akses
* akses_acc
* akses_entitas
* akses_login
* akses_pengajuan
* akses_ref
* akun_perkiraan

### InteSystem Integration ###

* BPJS
* SATUSEHAT
* SIMRS Online
* Email Gateway
* Radix
* Analyza

### Documentation Link ###

* Git Book : https://rsu-el-syifa.gitbook.io/rsu-el-syifa-docs

### What's Changed In This Version? ###
* Generate captcha and save on database
* Login system, validation from login token
* There is a relationship between tables in the access module

