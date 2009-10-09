<?php

class sfEasyGMapPluginActions extends sfActions
{

  public function executeIndex()
  {
    $this->available_samples = array(
      '1' => array('url' => 'sfEasyGMapPlugin/sample1', 'name' => 'Sample 1', 'message' => 'Simple map with some markers, using longitudes and latitudes.'),
      '2' => array('url' => 'sfEasyGMapPlugin/sample2', 'name' => 'Sample 2', 'message' => 'Basic events on marker and map.'),
      '3' => array('url' => 'sfEasyGMapPlugin/sample3', 'name' => 'Sample 3', 'message' => 'Basic GMapInfoWindow sample.'),
      '4' => array('url' => 'sfEasyGMapPlugin/sample4', 'name' => 'Sample 4', 'message' => 'How to center the map on a tag cloud.'),
      '5' => array('url' => 'sfEasyGMapPlugin/sample5', 'name' => 'Sample 5', 'message' => 'Center the map on a given map and display inside markers.'),
      '6' => array('url' => 'sfEasyGMapPlugin/sample6', 'name' => 'Sample 6', 'message' => 'How to set a custom marker.'),
    );
  }

  /**
   * Simple map with markers
   *
   * @author Vincent Guillon <vincentg@theodo.fr>
   * @since 2009-10-02 17:17:18
   */
  public function executeSample1()
  {
    // Initialize the google map
    $this->gMap = new GMap();
    $this->gMap->setCenter(48.397, 3.644);
    $this->gMap->setZoom(5);

    // Add some markers on the map
    $this->gMap->addMarker(
      new GMapMarker(51.245475,6.821373)
    );
    $this->gMap->addMarker(
      new GMapMarker(46.262248,6.115969)
    );
    $this->gMap->addMarker(
      new GMapMarker(48.848959,2.341577)
    );
    $this->gMap->addMarker(
      new GMapMarker(48.718952,2.219180)
    );
    $this->gMap->addMarker(
      new GMapMarker(47.376420,8.547995)
    );

    // END OF ACTION
    $this->message = 'Simple google map with markers';
    $this->action_source = $this->functionToString('executeSample1');
    $this->generated_js = str_replace(' ', '&nbsp;', preg_replace('/^\n(.*)/', '$1', $this->gMap->getJavascript()));
  }


  /**
   * Marker/Map event sample
   *
   * @author Vincent Guillon <vincentg@theodo.fr>
   * @since 2009-10-02 16:56:25
   */
  public function executeSample2()
  {
    // Initialize the google map
    $gMap = new GMap();
    $gMap->setZoom(4);
    $gMap->setCenter(-25.363882, 131.044922);

    // Create marker
    $marker = new GMapMarker(-12.461334, 130.841904, array('title' => '"Hello World !"'));
    
    // Add event on marker
    $marker->addEvent(new GMapEvent('click', 'moveToMarker();'));
    
    // Add marker on the map
    $gMap->addMarker($marker);

    // Add event on the map
    $gMap->addEvent(new GMapEvent('click', 'gmapSample_AddConsoleLine("You just click on the map !")'));

    $this->gMap = $gMap;

    $this->setTemplate('sample1');

    // END OF ACTION
    $this->message = 'Simple events : <br /> - click marker to focus on<br /> - click on the map for test map event';
    $this->action_source = $this->functionToString('executeSample2');
    $this->generated_js = str_replace(' ', '&nbsp;', preg_replace('/^\n(.*)/', '$1', $this->gMap->getJavascript()));
  }


  /**
   * GMapInfoWindow sample
   *
   * @author Vincent Guillon <vincentg@theodo.fr>
   * @since 2009-10-02 17:16:44
   */
  public function executeSample3()
  {
    // Initialize the google map
    $gMap = new GMap();
    $gMap->setZoom(13);
    $gMap->setCenter(-12.461334, 130.841904);

    // Create GMapInfoWindow
    $info_window = new GMapInfoWindow('<div>Your HTML content here !</div>');

    // Create marker
    $marker = new GMapMarker(-12.461334, 130.841904, array('title' => '"Darwin"'));
    $marker->addHtmlInfoWindow($info_window);
    $gMap->addMarker($marker);

    $this->gMap = $gMap;

    $this->setTemplate('sample1');

    // END OF ACTION
    $this->message = 'Simple GMapInfoWindow : click marker to open info window';
    $this->action_source = $this->functionToString('executeSample3');
    $this->generated_js = str_replace(' ', '&nbsp;', preg_replace('/^\n(.*)/', '$1', $this->gMap->getJavascript()));
  }

  /**
   * Here we learn to:
   *  - adapt the map to the current markers using complex but hidden formulas :-)
   */
  public function executeSample4()
  {
    // Initialize google map
    $this->gMap = new GMap();

    // Add some markers
    $this->gMap->addMarker(
      new GMapMarker(51.245475,6.821373)
    );
    $this->gMap->addMarker(
      new GMapMarker(46.262248,6.115969)
    );
    $this->gMap->addMarker(
      new GMapMarker(48.848959,2.341577)
    );
    $this->gMap->addMarker(
      new GMapMarker(48.718952,2.219180)
    );
    $this->gMap->addMarker(
      new GMapMarker(47.376420,8.547995)
    );
    
    // Center the map on marker width 0.3 margin
    $this->gMap->centerAndZoomOnMarkers(0.3);
    
    $this->setTemplate('sample1');

    // END OF ACTION
    $this->message = 'Center the map on the markers.';
    $this->action_source = $this->functionToString('executeSample4');
    $this->generated_js = str_replace(' ', '&nbsp;', preg_replace('/^\n(.*)/', '$1', $this->gMap->getJavascript()));
  }

  /**
   * Here we learn to:
   *  - center on a given place and guess the bounds from the zoom and center
   */
  public function executeSample5()
  {
    $this->gMap = new GMap();
    $this->gMap->setWidth(512);
    $this->gMap->setHeight(400);
    // center on Paris
    $this->gMap->setCenter(48.857939,2.346611);
    // nice zoom
    $this->gMap->setZoom(11);

    $bounds = $this->gMap->getBoundsFromCenterAndZoom(48.857939, 2.346611, 11, 512, 400);

    $markers = array(
      new GMapMarker(51.245475,6.821373),
      new GMapMarker(46.262248,6.115969),
      new GMapMarker(48.848959,2.341577),
      new GMapMarker(48.718952,2.219180),
      new GMapMarker(47.376420,8.547995),
    );

    foreach($markers as $marker)
    {
      if ($marker->isInsideBounds($bounds))
      {
        $this->gMap->addMarker($marker);
      }
    }

    $this->setTemplate('sample1');

    // END OF ACTION
    $this->message = 'Center the map on a given place and display only inside markers.';
    $this->action_source = $this->functionToString('executeSample5');
    $this->generated_js = str_replace(' ', '&nbsp;', preg_replace('/^\n(.*)/', '$1', $this->gMap->getJavascript()));
  }

  /**
   * Custom GMap marker sample
   * 
   * @author Vincent Guillon <vincentg@theodo.fr>
   * @since 2009-10-02 17:36:37
   */
  public function executeSample6()
  {
    // Initialize the google map
    $this->gMap = new GMap();
    $this->gMap->setWidth(512);
    $this->gMap->setHeight(400);
    $this->gMap->setCenter(48.857939,2.346611);
    $this->gMap->setZoom(11);
    
    // Create GMapIcon
    $icon = new GMapMarkerImage(
      '/sfEasyGMapPlugin/images/nice_icon.png',
      array(
        'width' => 18,
        'height' => 25,
      )
    );

    // Marker
    $marker = new GMapMarker(48.848959, 2.341577, array('icon' => $icon));
    $this->gMap->addMarker($marker);

    $this->setTemplate('sample1');

    // END OF ACTION
    $this->message = 'Custom marker.';
    $this->action_source = $this->functionToString('executeSample6');
    $this->generated_js = str_replace(' ', '&nbsp;', preg_replace('/^\n(.*)/', '$1', $this->gMap->getJavascript()));
  }
  
  function functionToString($function_name)
  {
    $text = file_get_contents(__FILE__);
    preg_match('/function '.$function_name.'\(\)\n  \{\n(.*)\n    \/\/ END OF ACTION$/msU', $text, $matches);
    
    return str_replace('&nbsp;&nbsp;&nbsp;&nbsp;' , '', str_replace(' ', '&nbsp;', $matches[1]));
  }
}