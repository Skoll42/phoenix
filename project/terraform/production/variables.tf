variable "access_key" {}
variable "secret_key" {}
variable "region" {}

variable "domain_name" {}
variable "primary_zone_id" { default = "Z2EXP43DSZXDJ4" }

variable "prod_varnish_server_name" {}
variable "prod_varnish_server_zone_id" {}

variable "application_name" {}
variable "stack_name" { default = "Production" }
