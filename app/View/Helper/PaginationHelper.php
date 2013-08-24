<?php 

/**
 * Pagination Helper, responsible for managing the LINKS required for pagination.
 * ALL parameters are specified in the component.
 **/
 
class PaginationHelper extends Helper 
{

/**
 * Options to be passed to ajax links if used
 *
 * @var array
 * @access public
 */
    var $ajaxLinkOptions = array();
/**
 * Placeholder for the link style - defined in/by the component
 *
 * @var boolean
 * @access private
 */
    var $style = 'html';
/**
 * Placeholder for the parameter style - defined in/by the component
 *
 * @var boolean
 * @access private
 */
    var $paramStyle = 'get';
/**
 * Placeholder for the pagination details
 *
 * @var array
 * @access private
 */
    var $_pageDetails = Array();
	var $clsNormal		= "pagination";
	var $clsSelected	= "pagination";
	var $clsNextNormal	= "pagination";
	
/**
 * Helpers
 *
 * @var array
 * @access private
 */
    var $helpers = Array("Html","Ajax");

	
/**
 * Sets the default pagination options. Fails if the value $paging is not set
 *
 * @param array $paging an array detailing the page options
 * @return boolean
 */
    function setPaging($paging)
    {
        if (empty($paging)) {return false;}
        $this->_pageDetails = $paging;
        $this->_pageDetails['previousPage'] = ($paging['page']>1) ? $this->_pageDetails['page']-1 : '';
        $this->_pageDetails['nextPage'] = ($paging['page'] < $this->_pageDetails['pageCount']) ? $this->_pageDetails['page']+1 : '';
      	$this->url = $this->_pageDetails['url'];        
        $getParams = $this->request->params['url'];
        unset($getParams['url']);
        $this->getParams = $getParams;        
        $this->showLimits = $this->_pageDetails['showLimits'];
        $this->style = isset($this->_pageDetails['style'])?$this->_pageDetails['style']:$this->style;        if (($this->_pageDetails['maxPages'] % 2)==0) // need odd number of page links
        {
            $this->_pageDetails['maxPages'] = $this->_pageDetails['maxPages']-1;
        }        
        $this->maxPages = $this->_pageDetails['maxPages'];
        $this->pageSpan = ($this->_pageDetails['maxPages']-1)/2;        
           return true;
    }
    
/**
* Displays the list of pages for the given parameters.
*
* @param string text to display before limits
* @param string display a separate between limits
* @param boolean whether to escape the title or not
* @return unknown the html string for modifying the number of results per page
**/
    function resultsPerPage($t="", $separator=" ",$escapeTitle=true,$refreshpag=NULL)
    {
        if (empty($this->_pageDetails)) { return false; }
        $pageDetails = $this->_pageDetails;
		$page=$this->_pageDetails['page'];
        if ( !empty($pageDetails['pageCount']) )
        {
            if(is_array($pageDetails['resultsPerPage']))
            {
                $OriginalValue = $pageDetails['show'];
                $t .= $separator;
                foreach($pageDetails['resultsPerPage'] as $value)
                {
                    if($OriginalValue == $value)
                    {
                        $t .= '<em>'.$value.'</em>'.$separator;
                    }
                    else
                    {
                        $pageDetails['show'] = $value;
                        $t .= $this->_generateLink($value,$page,$escapeTitle,$pageDetails,NULL,$refreshpag).$separator;
                    }
                }
            }
            return $t;
        }
        return false;
    }

/**
* Generate a select box for options for results per page
*
* @param string prefix text
* @return unknown the html string for the select box for modifying the number of results per page
**/
    function resultsPerPageSelect($t="")
    {
        if (empty($this->_pageDetails)) { return false; }
        if ( !empty($this->_pageDetails['pageCount']) )
        {
            $Options = Array();
            if(is_array($this->_pageDetails['resultsPerPage']))
            {
                foreach($this->_pageDetails['resultsPerPage'] as $value)
                {
                    $Options[$value] = $value;
					
                }
            }
			$attributes['class']='select_box';
			 return $t.$this->Html->selectTag("pagination/show", $Options, $this->_pageDetails['show'], $attributes,NULL,FALSE);
        }
        return false;
    }

/**
* Displays info of the current result set
*
* @param string prefix text
* @param string
* @param string
* @return unknown the html string for the current result set.
**/
    function result($t="Results: ",$of=" of ",$inbetween="-")
    {
        if (empty($this->_pageDetails)) { return false; }
        if ( !empty($this->_pageDetails['pageCount']) )
        {
          /*  if($this->_pageDetails['pageCount'] > 1)
            {*/
                $start_row = (($this->_pageDetails['page']-1)*$this->_pageDetails['show'])+1;
                $end_row = min ((($this->_pageDetails['page'])*$this->_pageDetails['show']),($this->_pageDetails['total']));
                $t = $t.$start_row.$inbetween.$end_row.$of.$this->_pageDetails['total'];
          /*  }
            else
            {
                $t .= $this->_pageDetails['total'];
            }*/
            return $t;
        }
        return false;
    }
/**
* Returns a list of page numbers separated by $separator
*
* @param string $separator - defaults to null
* @param boolean
* @param string $spacerLower - If there are more results than space for the links, the text inbetween
* @param string $spacerUpper - If there are more results than space for the links, the text inbetween
* @return string html for the list of page numbers
**/
    function pageNumbers($separator=" ",$escapeTitle=true,$spacerLower="...",$spacerUpper="...")
    {
        if (empty($this->_pageDetails) || $this->_pageDetails['pageCount'] == 1) { return "<span class='{$this->clsSelected}'>1</span>"; }
        $total = $this->_pageDetails['pageCount'];
        $max = $this->maxPages;
        $span = $this->pageSpan;

        if ($total<$max)
        {
            $upperLimit = min($total,($span*2+1));
            $lowerLimit = 1;
        }
        elseif ($this->_pageDetails['page']<($span+1))
        {
            $lowerLimit = 1;
            $upperLimit = min($total,($span*2+1));
        }
        elseif ($this->_pageDetails['page']>($total-$span))
        {
            $upperLimit = $total;
            $lowerLimit = max(1,$total-$span*2);
        }
        else
        {
            $upperLimit = min ($total,$this->_pageDetails['page']+$span);
            $lowerLimit = max (1,($this->_pageDetails['page']-$span));
        }
        
        $t = array();
        if (($lowerLimit<>1)AND($this->showLimits))
        {
            $lowerLimit = $lowerLimit+1;
            $t[] = $this->_generateLink(1,1,$escapeTitle,NULL);
            if ($spacerLower)
            {
                $t[] = $spacerLower;
            }
        }
        if (($upperLimit<>$total)AND($this->showLimits))
        {
            $dottedUpperLimit = true;
        }
        else
        {
            $dottedUpperLimit = false;
        }
        if (($upperLimit<>$total)AND($this->showLimits))
        {
            $upperLimit = $upperLimit-1;
        }
        for ($i = $lowerLimit; $i <= $upperLimit; $i++)
        {
             if($i == $this->_pageDetails['page'])
             {
                $text = "<span class='{$this->clsSelected}'>".$i.'</span> ';
             }
             else
             {
				$text = $this->_generateLink($i,$i,$escapeTitle,NULL);
             }
             $t[] = $text;
        }
        if ($dottedUpperLimit)
        {
            if ($spacerUpper)
            {
                $t[] = $spacerUpper;
            }
            $t[] = $this->_generateLink($this->_pageDetails['pageCount'],$this->_pageDetails['pageCount'],$escapeTitle,NULL);
        }
        $t = implode($separator, $t);
        return $t;
    }
   
	
/**
* Displays a link to the previous page, where the page doesn't exist then
* display the $text
*
* @param string $text - text display: defaults to next
* @return string html for link/text for previous item
**/
    function prevPage($text='prev',$escapeTitle=true)
    {
	    
        if (empty($this->_pageDetails)) { return false; }
        if ( !empty($this->_pageDetails['previousPage']) )
        {
		
            return $this->_generateLink($text,$this->_pageDetails['previousPage'],$escapeTitle,null,$this->clsNextNormal);
        }
        return $text;
    }
    
/**
* Displays a link to the next page, where the page doesn't exist then
* display the $text
*
* @param string $text - text to display: defaults to next
* @return string html for link/text for next item
**/
    function nextPage($text='next',$escapeTitle=true)
    {
	    
        if (empty($this->_pageDetails)) { return false; }
        if (!empty($this->_pageDetails['nextPage']))
        {
		    
			 return $this->_generateLink($text,$this->_pageDetails['nextPage'],$escapeTitle,null,$this->clsNextNormal);
			
        }
        return $text;
    }

/**
* Displays a link to the first page
* display the $text
*
* @param string $text - text to display: defaults to next
* @return string html for link/text for next item
**/
    function firstPage($text='first',$escapeTitle=true)
    {
        if (empty($this->_pageDetails)) { return false; }
        if ($this->_pageDetails['page']<>1)
        {
            return $this->_generateLink($text,1,$escapeTitle);
        }
        else
        {
            return false;
        }
    }

/**
* Displays a link to the last page
* display the $text
*
* @param string $text - text to display: defaults to next
* @return string html for link/text for next item
**/
    function lastPage($text='last',$escapeTitle=true)
    {
        if (empty($this->_pageDetails)) { return false; }
        if ($this->_pageDetails['page']<>$this->_pageDetails['pageCount'])
        {
            return $this->_generateLink($text,$this->_pageDetails['pageCount'],$escapeTitle);
        }
        else
        {
            return false;
        }
    }


/**
* Generate link to sort the results by the given value
*
* @param string field to sort by
* @param string title for link defaults to $value
* @param string model to sort by - uses the default model class if absent
* @param boolean escape title
* @param string text to append to links to indicate sorted ASC
* @param string text to append to links to indicate sorted DESC
* @return string html for link to modify sort order
**/
    function sortBy($value, $title=NULL, $Model=NULL,$escapeTitle=true,$upText=" ^",$downText=" v") 
    {
        if (empty($this->_pageDetails)) { return false; }
        $title = $title?$title:ucfirst($value);
        $value = strtolower($value);
        $Model = $Model?$Model:$this->_pageDetails['Defaults']['sortByClass'];

        $OriginalSort = $this->_pageDetails['sortBy'];
        $OriginalModel = $this->_pageDetails['sortByClass'];
        $OriginalDirection = $this->_pageDetails['direction'];
		$page=$this->_pageDetails['page'];

        if (($value==$OriginalSort)&&($Model==$OriginalModel)) 
        {
            if (strtoupper($OriginalDirection)=="DESC") 
            {
                $this->_pageDetails['direction'] = "ASC";
				$link1 = "<img src='".COMMON_URL."/images/sort_desc.gif' alt='v' width='15' height='16' class='sortimg'  /> ";				
                //$title .= $upText;
            } 
            else 
            {
                $this->_pageDetails['direction'] = "DESC";
				$link1 = "<img src='".COMMON_URL."/img/sort_asc.gif' alt='^' width='15' height='16' class='sortimg'  /> ";
				
                //$title .= $downText;
            }
        }
        else
        {
            if ($Model) 
            {
                $this->_pageDetails['sortByClass'] = $Model;
				$link1 = "<img src='".COMMON_URL."/img/sort_none.gif' alt='v' width='15' height='16' class='sortimg'  /> ";
                //echo "page details model class set to ".$this->_pageDetails['sortByClass']."<br>";
            }
            else
            {
                $this->_pageDetails['sortByClass'] = NULL;
				$link1 = "<img src='".COMMON_URL."/img/sort_none.gif' alt='v' width='15' height='16' class='sortimg'  /> ";
            }
            $this->_pageDetails['sortBy'] = $value;
        }
		
        $link = $this->_generateLink ($title,$page,$escapeTitle);
		$imglink=$this->_generateLink ($link1,$page,$escapeTitle);
        $this->_pageDetails['sortBy'] = $OriginalSort;
        $this->_pageDetails['sortByClass'] = $OriginalModel;
        $this->_pageDetails['direction'] = $OriginalDirection;
        return $link." ".$imglink;
    }

/**
* Generate a select box for options to sort results
*
* @param array array of text strings, formatted as "Field::Direction::Class".
* @param string prefix text
* @param string text to append to links to indicate sorted ASC
* @param string text to append to links to indicate sorted DESC
* @return unknown the html string for the select box for selecting sort order
**/
    function sortBySelect($sortFields, $t="Sort By: ",$upText=" ^",$downText=" v")
    {
	   
        if (empty($this->_pageDetails)) { return false; 	 }
        if ( !empty($this->_pageDetails['pageCount']) )
        {	
            $OriginalValue = $this->_pageDetails['sortBy']."::".$this->_pageDetails['direction']."::".$this->_pageDetails['sortByClass'];
            if(is_array($sortFields))
            {
                foreach($sortFields as $value)
                {
                    $Vals = Array();
                    $Vals = explode("::",$value);
                    if (isset($Vals[2]))
                    {
                        $DisplayVal = $Vals[2]." ";
                    }
                    else
                    {
                        $DisplayVal = "";
                    }
                    $DisplayVal .= $Vals[0];
                    if (strtoupper($Vals[1])=="ASC")
                    {
                        $DisplayVal .= $downText;
                    }
                    else
                    {
                        $DisplayVal .= $upText;                        
                    }
                    $Options[$value] = $DisplayVal;
                }
                return $t.$this->Html->selectTag("pagination/sortByComposite", $Options, $OriginalValue, NULL, NULL,FALSE);
            }
        }
        return false;
    }
    
/**
* Internal method to generate links based upon passed parameters.
*
* @param string title for link
* @param string page the page number
* @param boolean escape title
* @param string the div to be updated by AJAX updates
* @return string html for link
**/
    function _generateLink($title,$page=NULL,$escapeTitle,$pageDetails = NULL,$class=NULL,$refreshpag=NULL) 
    {
	    
	    if($class==NULL)
		{
	       $class=$this->clsNormal;
		}
		 
		$pageDetails = $pageDetails?$pageDetails:$this->_pageDetails;
        $url = $this->_generateUrl($page,$pageDetails);
        $AjaxDivUpdate = $pageDetails['ajaxDivUpdate'];
        if ($this->style=="ajax")
        {
            $options = am($this->ajaxLinkOptions,
                            array(
                                "update" => $pageDetails['ajaxDivUpdate'],"class"=>$class,"loading"=>"Element.show('divloading');", "complete"=>"Element.hide('divloading');"));
			if($refreshpag)
			{
			   	$options = am($this->ajaxLinkOptions,
                            array(
                                "update" => $pageDetails['ajaxDivUpdate'],"class"=>$class,"loading"=>"Element.show('divloading');", "complete"=>"Element.hide('divloading');switchonoffsame();"));
			}
            if (isset($pageDetails['ajaxFormId']))
            {
                $id = 'link' . intval(rand());
                $return = $this->Html->link(
                                $title,
                                $url,
                                array('id' => $id, 'onclick'=>" return false;",'class'=>$class),
                                NULL,
                                $escapeTitle
                                    );
                $options['with'] = "Form.serialize('{$this->_pageDetails['ajaxFormId']}')";
                $options['url'] = $url;
				$options['class'] = $class;
                $return .= $this->Ajax->Javascript->event("'$id'", "click", $this->Ajax->remoteFunction($options));
                return $return;
            }
            else
            {

                return $this->Ajax->link(
                                $title,
                                $url,
                                $options,
                                NULL,
                                NULL,
                                $escapeTitle
                                    );
            }
        }
        else
        {
			
            return $this->Html->link(
                            $title,
                            $url,
							array('class'=>$class),
                            NULL,
                            $escapeTitle
                                );
        }
    }
	
	
	
	
	

    function _generateUrl ($page=NULL,$pageDetails=NULL) 
    {
        $pageDetails = $pageDetails?$pageDetails:$this->_pageDetails;
        $getParams = $this->getParams; // Import any other pre-existing get parameters
        if ($this->_pageDetails['paramStyle']=="pretty")
        {
            $pageParams=$pageDetails['importParams'];
        }
        $pageParams['show'] = $pageDetails['show'];
        $pageParams['sortBy'] = $pageDetails['sortBy'];
        $pageParams['direction'] = $pageDetails['direction'];
        $pageParams['page'] = $page?$page:$pageDetails['page'];
        if (isset($pageDetails['sortByClass']))
        {
            $pageParams['sortByClass'] = $pageDetails['sortByClass'];
        }
        $getString = Array();
        $prettyString = Array();
        if ($pageDetails['paramStyle']=="get")
        {
            $getParams = am($getParams,$pageParams);
        }
        else
        {
            foreach($pageParams as $key => $value)
            {
                if (isset($pageDetails['Defaults'][$key]))
                {
                    if (strtoupper($pageDetails['Defaults'][$key])<>strtoupper($value))
                    {
                        $prettyString[] = "$key{$pageDetails['paramSeperator']}$value";
                    }
                }
                else
                {
                    $prettyString[] = "$key{$pageDetails['paramSeperator']}$value";
                }            
            }
        }

		foreach($getParams as $key => $value)
        {
            if ($pageDetails['paramStyle']=="get")
            {
                if (isset($pageDetails['Defaults'][$key]))
                {
					
                       $getString[] = "$key=$value";
                 }
                else
                {
                     $getString[] = "$key=$value";
                }
            }
            else
            {
                $getString[] = "$key=$value";
            }            
        }

        $url = $this->url;
        if ($prettyString)
        {
            $prettyString = implode ("/", $prettyString);
            $url .= $prettyString;
        }
        if ($getString)
        {
            $getString = implode ("&", $getString);
            $url .= "?".$getString;
        }
        return $url;
    }
    
    /**
   * Displays page navigation links
   *
   * @param string $html list of page numbers 
   *       (as generated by PaginationHelper::pageNumbers)
   * @param string $prev text (or html) to put in link to previous page
   * @param string $next text (or html) to put in link to next page
   * @param boolean $escape_text indicates whether we escape html entities of
   *        prev and next.
   * @return string the html for page navigation links.
   **/
  function nav($pages, $prev = null, $next = null, $escape_text = true)
  {
    $nav = '';
    if ($this->_pageDetails['total'] > $this->_pageDetails['show']) {

      $prev = $this->prevPage($prev, $escape_text);
      $next = $this->nextPage($next, $escape_text);

      if ($this->_pageDetails['page'] > 1) {
        $nav .= $prev." ";
      }
      $nav .= $pages;
      $npages = (int)($this->_pageDetails['total'] / $this->_pageDetails['show']);
      $r = $this->_pageDetails['total'] % $this->_pageDetails['show'];
      if ($r) { $npages++; }
      if ($this->_pageDetails['page'] < $npages) {
        $nav .= " ".$next;
      }
    }
    return $nav;
  } 
}
