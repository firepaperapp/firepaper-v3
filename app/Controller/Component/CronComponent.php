<?php
class CronComponent extends Component {
    /*     * *
     * Merchantware Component class
     *
     * Issue Sale (Keyed) & Issue Repeat Sale
     * @filesource
     * @copyright  Copyright � 2009 Ids Infotech
     * @version 0.0.1
     *   - Initial release
     */
    var $controller;

    function startup(&$controller) {
        $this->controller = &$controller;
    }
   /**
   * Verify CakePHP was invoked by the cron dispatcher, or die.
   */
  function check_cli() {
      
    if (php_sapi_name() === "cli") {
      return true;
    }
    else{
        return false;
    }
  }

}

?>