module "vpc" {
  source = "./../modules/vpc"

  # VPC
  vpc_prefix = "10.41"
  key_filename = "betavest-dev"

  # Default
  application_key = "${lower(var.application_name)}-${lower(var.stack_name)}"
  application_fullname = "${var.application_name} ${var.stack_name}"
  application_name = "${var.application_name}"
  stack_name = "${var.stack_name}"
}
