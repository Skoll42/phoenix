module "alarm" {
  source = "./../modules/alarm"

  rds_credit_balance_threshold = "50"
  rds_free_storage_spage_threshold = "1073741824"
  rds_identifier = "${module.db.master_identifier}"

  app_credit_balance_threshold = "20"
  app_auto_scaling_group = "awseb-e-k8waik5cep-stack-AWSEBAutoScalingGroup-4EC761D58PM1"
  app_environment_topic_arn = "arn:aws:sns:eu-west-1:608064952666:ElasticBeanstalkNotifications-Environment-maritime-prod"

  varnish_credit_balance_threshold = "20"
  varnish_auto_scaling_group = "awseb-e-pwn4inwqjs-stack-AWSEBAutoScalingGroup-9A8GIV1WKKUM"
  varnish_environment_topic_arn = "arn:aws:sns:eu-west-1:608064952666:ElasticBeanstalkNotifications-Environment-maritime-prod-varnish"

  # Default
  application_key = "${lower(var.application_name)}-${lower(var.stack_name)}"
  application_fullname = "${var.application_name} ${var.stack_name}"
  application_name = "${var.application_name}"
  stack_name = "${var.stack_name}"
}
