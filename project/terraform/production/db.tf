module "db" {
  source = "./../modules/db"

  # DB master
  m_instance_class = "db.t2.small"
  m_name = "ebdb"
  m_username = "phroot1231"
  m_password = "R4K-fEg-cv1-fP0"
  m_security_group_id = "${module.vpc.security_group_rds_id}"
  m_snapshot_identifier = ""
  m_multi_az = true

  # Subnet
  apply_immediately = true
  subnet_ids = "${module.vpc.subnet_rds_zone_b_id},${module.vpc.subnet_rds_zone_c_id}"

  # Default
  application_key = "${lower(var.application_name)}-${lower(var.stack_name)}"
  application_fullname = "${var.application_name} ${var.stack_name}"
  application_name = "${var.application_name}"
  stack_name = "${var.stack_name}"
}
