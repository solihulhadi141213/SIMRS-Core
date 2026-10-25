# SIMRS CORE V 3.0.0 (Beta) #

SIMRS Core V3 is an improvement over the previous version, SIMRS V2.
This version features significant changes and a different way of working.
SIMRS Core V3 is a hospital management information system integrated with electronic medical records. The application is built on a microservice basis, enabling other applications to communicate with the central SIMRS database. Patient medical information is written using FHIR. An API service is available for easier application development.

### System Specifications ###

* PHP 8.x
* MySql 9.1.0
* Apache 2.4.62.1

### Requirements ###

* PHP 8.2 or later with the `mysqli` extension enabled
* MySQL-compatible database with the application schema imported
* A command-line terminal for running the initial installer

### Active Features ###

* Dashboard and hospital operations modules
* User, access-entity, and feature-permission management
* Reference data and external integrations listed under [Module](#module)

### Initial Installation ###

1. Create the application database and import `_Database/schema.sql` before continuing.
2. Configure the database connection in `_Config/Connection.php`.
3. Ensure `_Database/referance/default_reference_feature_code.json` is present.
4. From the project root, run `php instal.php` once using the server's PHP CLI.
5. Enter the administrator email and password when prompted. The password is entered visibly in the CLI and stored as a password hash.

The installer seeds the `akses_fitur` table from the reference JSON when it is empty, creates the default `Admin` access entity, assigns all features to that entity, creates the `Admin Faskes` account, and grants the account all features. The account's `tanggal` and `updatetime` values are stored in UTC. The installer refuses to run if access accounts or entities already exist, preventing accidental duplicate setup.

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
* nullpunkt/lz-string-php ^1.3
* mpdf/mpdf ^8.1
* ezyang/htmlpurifier ^4.19
* phpoffice/phpspreadsheet ^1.30


### Module ###

* Dashboard
* Pengaturan
  - Pengaturan Umum
  - API Key
  - Email Gateway
  - Google Credential
  - Aksesibilitas
    - Fitur Aplikasi
    - Entitas Akses
    - Akun Pengguna
    - Pengajuan Akses
  - Integrasi
    - Bridging BPJS
    - SATUSEHAT
    - SIRS Online
    - Radix
    - Analyza
    - Sifarma
  - Laporan Kesalahan
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
* Activity history is not recorded partially, but is recorded based on data that has been created.

### Referance
* Bridging BPJS : https://dvlp.bpjs-kesehatan.go.id:8888/trust-mark/portal.html
