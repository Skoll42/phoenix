module "db" {
  source = "./../modules/db"

  # DB master
  m_instance_class = "db.t2.medium"
  m_name = "ebdb"
  m_username = "btroot5432"
  m_password = "B3A-CEF-cd1-Bro"
  m_security_group_id = "${module.vpc.security_group_rds_id}"
  m_snapshot_identifier = ""
  m_multi_az = false

  # Subnet
  apply_immediately = true
  subnet_ids = "${module.vpc.subnet_rds_zone_b_id},${module.vpc.subnet_rds_zone_c_id}"

  # Default
  application_key = "${lower(var.application_name)}-${lower(var.stack_name)}"
  application_fullname = "${var.application_name} ${var.stack_name}"
  application_name = "${var.application_name}"
  stack_name = "${var.stack_name}"
}
