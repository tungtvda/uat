<div id="debug">
  <h1>Debug Mode ON</h1>
  <!-- Load -->
  <strong>Load Array:</strong><br />
  <?php Debug::displayArray($this->load); ?>
  <p>&nbsp;</p>

  <!-- Constant -->
  <?php $constant = get_defined_constants(true); ?>
  <strong>Constants:</strong><br />
  <?php Debug::displayArray($constant['user']); ?>
  <p>&nbsp;</p>
  
  <!-- Data -->
  <p><strong>Data Array:</strong></p>
  <?php Debug::displayArray($data); ?>
  <p>&nbsp;</p>
  
  <!-- Session Variables -->
  <p><strong>Session Variables:</strong></p>
  <?php Debug::displayArray($_SESSION); ?>
  <p>&nbsp;</p>
  
  <!-- POST Variables -->
  <p><strong>POST Variables:</strong>
  </p>
  <?php Debug::displayArray($_POST); ?>
  <p>&nbsp;</p>
  <p><strong>GET Variables:</strong>
  </p>
  
  <!-- GET Variables -->
  <?php Debug::displayArray($_GET); ?>
  <p>&nbsp;</p>
  
  <!-- Server / Browser -->
  <p><strong>User Agent:</strong>
    <?php echo((isset($_SERVER["HTTP_USER_AGENT"]))?$_SERVER["HTTP_USER_AGENT"]:""); ?><br />
      <strong>Server Name:</strong>
    <?php echo $_SERVER["SERVER_NAME"]; ?>
    <br />
      <strong>Server Request URI:</strong>
    <?php echo $_SERVER["REQUEST_URI"]; ?><br />
    </p>

    <!-- PHP Info -->
    <?php #phpinfo(); ?>
</div>

