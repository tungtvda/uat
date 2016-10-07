jQuery.fn.slug = function(options) {
    var settings = {
        slug: 'slug', 
        hide: true   
    };
    
    if(options) {
        jQuery.extend(settings, options);
    }
    
    $this = jQuery(this);

    jQuery(document).ready( function() {
        if (settings.hide) {
            jQuery('input#' + settings.slug).after("<span id="+settings.slug+"></span>");
            jQuery('input#' + settings.slug).hide();
        }
    });
    
    makeSlug = function() {
            var slugcontent = $this.val();
            var slugcontent_hyphens = slugcontent.replace(/\s/g,'-');
            var finishedslug = slugcontent_hyphens.replace(/[^a-zA-Z0-9\-]/g,'');
            jQuery('input#' + settings.slug).val(finishedslug.toLowerCase());
            jQuery('span#' + settings.slug).text(finishedslug.toLowerCase());
            
            jQuery('#' + settings.slug).validationEngine('validate');
        }
        
    jQuery(this).keyup(makeSlug);
    jQuery(this).change(makeSlug);
    jQuery(this).click(makeSlug);
        
    return $this;
};
