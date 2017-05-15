variable "access_key" {}
variable "secret_key" {}
variable "region" {}

variable "dev_domain_name" {}
variable "primary_zone_id" { default = "Z37Q6AFNL27IU8" }

variable "stage_varnish_server_name" {}
variable "stage_varnish_server_zone_id" {}

variable "application_name" {}
variable "stack_name" { default = "Stage" }
