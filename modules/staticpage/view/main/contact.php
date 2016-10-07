<div id="contact_wrapper">
    <?php if ($data['page']['staticpage_contact']['ok']==1) { ?>
    <div class="notify">Thank you for your message. One of our staff will get back to you shortly.</div>
    <?php } ?>
    <!-- <div id="google_map"><img class="loader" src="<?php echo $data['config']['THEME_DIR']; ?>img/loader.gif" />Loading Map...</div>
    <div id="google_map_link"><a href="http://maps.google.com/maps?t=h&q=loc:<?php echo $data['config']['POSITION_MAP_X']; ?>,<?php echo $data['config']['POSITION_MAP_Y']; ?>&z=16" target="_blank">View Larger Map</a></div> -->
    <h2>Enquiry Form</h2><a name="form"></a>
    <p>We welcome your enquiry and feedback. Start by filling in the form below.</p>
    <div id="contact_box">
      <form id="contact_form" method="post" action="main/content/contactprocess">
        <table border="0" cellspacing="0" cellpadding="0">
          <tr>
            <th scope="row">Name<span class="label_required">*</span></th>
            <td><input type="text" class="validate[required]" name="Name" id="Name" size="40" />
            </td>
          </tr>
          <tr>
            <th scope="row">Company</th>
            <td><input type="text" class="validate[]" name="Company" id="Company" size="40" />
            </td>
          </tr>
          <tr>
            <th scope="row">Contact No<span class="label_required">*</span></th>
            <td><input type="text" class="validate[required, custom[phoneNo], minSize[9]" name="ContactNo" id="ContactNo" maxlength="15" size="20" /><span class="label_hint">(e.g. 0192255667)</span>
            </td>
          </tr>
          <tr>
            <th scope="row">Email<span class="label_required">*</span></th>
            <td><input type="text" class="validate[required, custom[email]]" name="Email" id="Email" size="30" /><span class="label_hint">(e.g. harry.porter@gmail.com)</span>
            </td>
          </tr>
          <tr>
            <th scope="row">&nbsp;</th>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <th scope="row">Subject<span class="label_required">*</span></th>
            <td><input type="text" class="validate[required] long" name="Subject" id="Subject" />
            </td>
          </tr>
          <tr>
            <th scope="row">Message<span class="label_required">*</span></th>
            <td><textarea name="Message" class="validate[required] long" id="Message" rows="6"></textarea>
            </td>
          </tr>
          <tr>
              <th scope="row"><label>Security Question<span class="label_required">*</span></label></th>
              <td><?php echo $data['captcha'][0]; ?> + <?php echo $data['captcha'][1]; ?> = <input name="SQ" class="validate[required,equals[C3]]" type="text" value="" size="3" /></td>
            </tr>
            <tr>
              <th scope="row">&nbsp;</th>
              <td><input type="hidden" name="C1" value="<?php echo $data['captcha'][0]; ?>"  /><input type="hidden" name="C2" value="<?php echo $data['captcha'][1]; ?>"  /><input type="hidden" id="C3" name="C3" value="<?php echo $data['captcha'][0] + $data['captcha'][1]; ?>"  /></td>
            </tr>
          <tr>
            <th scope="row">&nbsp;</th>
            <td><input type="hidden" id="HPot" name="HPot" value="" />
              <input type="hidden" id="ContactFormPost" name="ContactFormPost" value="1" />
              <input class="button" type="submit" name="submit" id="submit" value="Send" /></td>
          </tr>
        </table>
      </form>
    </div>
</div>
<?php /* ?>
<script type="text/javascript">
function initialize()
{
	var address = '<p id="google_map_box"><strong style="font-size:14px;"><?php echo $data['config']['COMPANY_NAME']; ?></strong><br /><?php echo $data['config']['COMPANY_ADDRESS']; ?></p>';

	var mapProp = {
		center:new google.maps.LatLng(<?php echo $data['config']['POSITION_MAP_X']+0.0010; ?>,<?php echo $data['config']['POSITION_MAP_Y']; ?>),
		zoom:16,
		mapTypeId:google.maps.MapTypeId.ROADMAP
	};
	var map=new google.maps.Map(document.getElementById("google_map"),mapProp);

	var marker=new google.maps.Marker({
		position:new google.maps.LatLng(<?php echo $data['config']['POSITION_MAP_X']; ?>,<?php echo $data['config']['POSITION_MAP_Y']; ?>),
	});

	marker.setMap(map);
	marker.setIcon('<?php echo $data['config']['THEME_DIR']; ?>img/logo_google_maps_marker.png')

	var infowindow = new google.maps.InfoWindow({
	  content:address
	  });

	infowindow.open(map,marker);
}

google.maps.event.addDomListener(window, 'load', initialize);
</script><?php */ ?>