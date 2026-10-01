<?php
/**
 * Google Analytics (GA4) event tracking.
 *
 * @package bellaworks
 */

/*-------------------------------------
  Fire "contact_form_submit_success" only after the
  Contact form (Gravity Forms ID 2) has been successfully submitted.
---------------------------------------*/
function bellaworks_ga4_contact_form_success( $confirmation, $form, $entry, $ajax ) {
  // Redirect confirmations return an array, there is no markup to append to.
  if ( ! is_string( $confirmation ) ) {
    return $confirmation;
  }

  // Entries flagged as spam still see the confirmation, don't count them.
  if ( rgar( $entry, 'status' ) === 'spam' ) {
    return $confirmation;
  }

  $entry_id = (int) rgar( $entry, 'id' );
  $params = array(
    'form_id'   => (int) $form['id'],
    'form_name' => $form['title'],
  );

  ob_start(); ?>
  <script>
  (function(){
    // Refreshing the confirmation page re-posts the form, only count an entry once.
    var entryId = <?php echo $entry_id; ?>;
    if (entryId) {
      try {
        var key = 'ga4_form_success_' + entryId;
        if (sessionStorage.getItem(key)) { return; }
        sessionStorage.setItem(key, '1');
        sessionStorage.removeItem('ga4_form_start_<?php echo (int) $form['id']; ?>');
      } catch (e) {}
    }
    window.dataLayer = window.dataLayer || [];
    function gtag(){ dataLayer.push(arguments); }
    gtag('event', 'contact_form_submit_success', <?php echo wp_json_encode( $params ); ?>);
  })();
  </script>
  <?php
  return $confirmation . ob_get_clean();
}
add_filter( 'gform_confirmation_2', 'bellaworks_ga4_contact_form_success', 10, 4 );

/*-------------------------------------
  Fire "contact_form_start" the first time a visitor
  types in or changes a field on the Contact form.
---------------------------------------*/
function bellaworks_ga4_contact_form_start( $form_string, $form ) {
  $form_id = (int) $form['id'];
  $params = array(
    'form_id'   => $form_id,
    'form_name' => $form['title'],
  );

  ob_start(); ?>
  <script>
  (function(){
    var key = 'ga4_form_start_<?php echo $form_id; ?>';
    var fired = false;
    function onStart(e) {
      if (fired || !e.target || !e.target.closest || !e.target.closest('#gform_<?php echo $form_id; ?>')) { return; }
      fired = true;
      document.removeEventListener('input', onStart, true);
      document.removeEventListener('change', onStart, true);
      // Only count one start per visit, even if the form re-renders with validation errors.
      try {
        if (sessionStorage.getItem(key)) { return; }
        sessionStorage.setItem(key, '1');
      } catch (err) {}
      window.dataLayer = window.dataLayer || [];
      function gtag(){ dataLayer.push(arguments); }
      gtag('event', 'contact_form_start', <?php echo wp_json_encode( $params ); ?>);
    }
    document.addEventListener('input', onStart, true);
    document.addEventListener('change', onStart, true);
  })();
  </script>
  <?php
  return $form_string . ob_get_clean();
}
add_filter( 'gform_get_form_filter_2', 'bellaworks_ga4_contact_form_start', 10, 2 );
