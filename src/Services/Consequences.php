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
        $this->device['message'] = 'Repeater not detected it may be off, network ok. Check power and network connection of repeater.';
      }
    } else {
    // No radio link
    // Any network issues
      if (strtolower($this->device['device_status'])!=='online') {
        $this->device['colour'] = 'red';
        $this->device['message'] = 'Network Issues: This repeater can\'t connect to other repeaters. Radios will still roam to it, suggest turning off roaming on radios';
        
      } else {
        $this->device['colour'] = 'red';
        $this->device['message'] = 'Repeater not detected it may be off, network ok. Check power and network connection of repeater.';
      }
    }
    return $this->device;
  }
}