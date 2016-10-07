<?php
// Define app deloyment environment (SIT, UAT, REG, PROD)
$app_environment = "UAT";

define("APP_ENVIRONMENT", $app_environment);

if (APP_ENVIRONMENT=="SIT")
{
}
else if (APP_ENVIRONMENT=="UAT")
{
    // Database
    define("DB_HOSTNAME", "localhost");
    define("DB_NAME", "allsys33_uat_yessys");
    define("DB_USER", "root");
    define("DB_PASSWORD", "");

    // Audit Site
    define("AUDIT_SITE", "YS-UAT");
}
else if (APP_ENVIRONMENT=="REG")
{
}
else if (APP_ENVIRONMENT=="PROD")
{
    // Database
    define("DB_HOSTNAME", "localhost");
    define("DB_NAME", "yessys33_coredb");
    define("DB_USER", "yessys33_coredb");
    define("DB_PASSWORD", ",rS~ZfMr}To3");

    // Audit Site
    define("AUDIT_SITE", "YS");
}


