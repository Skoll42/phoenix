
resource "aws_route53_record" "phoenix" {
  zone_id = "${var.primary_zone_id}"
  name = "phoenix"
  type = "A"

  alias {
    name = "${var.stage_varnish_server_name}"
    zone_id = "${var.stage_varnish_server_zone_id}"
    evaluate_target_health = false
  }
}

resource "aws_route53_record" "offshore" {
  zone_id = "${var.primary_zone_id}"
  name = "offshore"
  type = "A"

  alias {
    name = "${var.stage_varnish_server_name}"
    zone_id = "${var.stage_varnish_server_zone_id}"
    evaluate_target_health = false
  }
}

resource "aws_route53_record" "maritime" {
  zone_id = "${var.primary_zone_id}"
  name = "maritime"
  type = "A"

  alias {
    name = "${var.stage_varnish_server_name}"
    zone_id = "${var.stage_varnish_server_zone_id}"
    evaluate_target_health = false
  }
}

resource "aws_route53_record" "gronn" {
  zone_id = "${var.primary_zone_id}"
  name = "gronn"
  type = "A"

  alias {
    name = "${var.stage_varnish_server_name}"
    zone_id = "${var.stage_varnish_server_zone_id}"
    evaluate_target_health = false
  }
}

resource "aws_route53_record" "s1" {
  zone_id = "${var.primary_zone_id}"
  name = "s1"
  type = "A"

  alias {
    name = "${aws_s3_bucket.s1.website_domain}"
    zone_id = "${aws_s3_bucket.s1.hosted_zone_id}"
    evaluate_target_health = false
  }
}
