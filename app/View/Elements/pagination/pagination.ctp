<?php
      echo $this->Paginator->prev();
      echo "&nbsp;";
      echo $this->Paginator->numbers(array('separator'=>' '));
      echo "&nbsp;";
      echo $this->Paginator->next();
?>