<?php

namespace JonLynch\MerakiTile\Services;



class Consequences
{
  private array $device;
  
  
  public function __construct(array $device) {
    $this->device = $device;
  }

  public function get_consequence_for_device() {
    if (strtolower($this->device['device_status'])==='online' && strtolower($this->device['client_status'])==='online') {
      $this->device['colour'] = 'green';
      $this->device['message'] = 'Online';
      return $this->device;
    }

    // Handle logic when there is a radio link
    if (isset($this->device['radio_link']) && $this->device['radio_link']) {
      // Any network issues
      if (strtolower($this->device['device_status'])!=='online') {
        $this->device['colour'] = 'yellow';
        $this->device['message'] = 'Network issues affecting GPS traces, voice should work normally';
      } else {
        $this->device['colour'] = 'red';
        $this->device['message'] = 'VPN connected. Repeater is off or disconnected.';
      }
    } else {
    
    // Handle logic when the repeater sleeps
    if (isset($this->device['sleeps']) && $this->device['sleeps']) {
      if (strtolower($this->device['device_status'])!=='online') {
        $this->device['colour'] = 'red';
        $this->device['message'] = 'VPN not connected to Internet. Turn off roaming in this area';
      } else {
        $this->device['colour'] = 'yellow';
        $this->device['message'] = 'Repeater is powered off, this is expected when radios are not in use.';
      }
    }

    // No radio link and does not sleep
    // Any network issues
      if (strtolower($this->device['device_status'])!=='online') {
        $this->device['colour'] = 'red';
        $this->device['message'] = 'VPN not connected to Internet. Turn off roaming in this area';
        
      } else {
        $this->device['colour'] = 'red';
        $this->device['message'] = 'VPN connected. Repeater is off or disconnected.';
      }
    }
    return $this->device;
  }
}