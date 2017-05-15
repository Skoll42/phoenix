resource "aws_s3_bucket" "s1" {
  bucket = "s1.${var.domain_name}"
  acl = "public-read"

  website {
    index_document = "index.html"
    error_document = "error.html"
  }

  tags {
    Application = "${var.application_name}"
    Stack = "${var.stack_name}"
  }
}