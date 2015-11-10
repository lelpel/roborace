#include <Arduino.h>
#include <avr/io.h>
#include <avr/interrupt.h>
#include "ADC.h"
#include "setup.h"
#include <IRremote.h>
#include "config.h"
#include "motor.h"
#include "PWMServo.h"
#include <Servo.h>
//SENSORS
// return value in sm it used for convert from analod sharp sensor to sm
int read_gp2y0a_range(char value)
{
  int val = analogRead(value);
  val = 8762.88/(val/2 + 18.32)-12.06;
  if (val < 0) val = 150;
  if (val >150) val = 150;
  return  val; 
} 

unsigned char median_of_3( unsigned char  a, unsigned char b, unsigned char c )
{
  unsigned char the_max = max( max( a, b ), c );
  unsigned char the_min = min( min( a, b ), c );
  // unnecessarily clever code
  unsigned char the_median = the_max ^ the_min ^ a ^ b ^ c;
  return( the_median );
}



