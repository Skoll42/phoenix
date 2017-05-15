jQuery(document).ready(function() {
    var jobSdk = new JobSdk(jobbConfig.site, jobbConfig.stillinger_url);
    jobSdk.insertCarousel('.jobb-carousel');
    jobSdk.insertWidget('.jobb-widget');
    jobSdk.insertListPage('.jobb-page-list', {
        filter: jobbConfig.filter
    });
    jobSdk.insertDetailedPage('.jobb-page-detailed', {
        id: jobbConfig.id,
        titlePattern: '[positoin_title] - ' + jobbConfig.site_name + ' Jobb'
    });
});