#include <Arduino.h>
#include <avr/io.h>
#include <avr/interrupt.h>
#include "ADC.h"


volatile unsigned int adc_data[LAST_ADC_INPUT-FIRST_ADC_INPUT+1];
volatile unsigned int sen_data[LAST_ADC_INPUT-FIRST_ADC_INPUT+1];
volatile unsigned char marker_sensor_is_ready[4];


void ADC_setup()
{
  cli();
  // ADC initialization
  // ADC Clock frequency: 125,000 kHz
  // ADC Voltage Reference: Int., cap. on AREF
  // ADC Auto Trigger Source: ADC Stopped
  // Only the 8 most significant bits of
  // the AD conversion result are used
  // Digital input buffers on ADC0: Off, ADC1: Off, ADC2: Off, ADC3: Off
  // ADC4: Off, ADC5: Off
  DIDR0=0x00;
  ADMUX=FIRST_ADC_INPUT | (ADC_VREF_TYPE & 0xff);
  ADCSRA=0xCF;
  sei();
}

int mapInt (int x, int in_min, int in_max, int out_min, int out_max)
{
  return (x - in_min) * (out_max - out_min) / (in_max - in_min) + out_min;
}

// ADC interrupt service routine
// with auto input scanning
ISR(ADC_vect)
{
  static unsigned char uc_input_index=0;
  // Read the AD conversion result
  static unsigned char uc_input_index_last;
  uc_input_index_last = uc_input_index;
  adc_data[uc_input_index]=ADCW;
  // Select next ADC input
  if (++uc_input_index > (LAST_ADC_INPUT-FIRST_ADC_INPUT))
    uc_input_index=0;
  ADMUX=(FIRST_ADC_INPUT | (ADC_VREF_TYPE & 0xff))+uc_input_index;
  // Delay needed for the stabilization of the ADC input voltage
  //delay_us(10);
  if(uc_input_index_last<4)
  {
    volatile unsigned int val = (8762.88/(adc_data[uc_input_index_last]/2 + 18.32)-12.06);
    sen_data[uc_input_index_last] = (val>150?150:val);
    marker_sensor_is_ready[uc_input_index_last] = 1;
  }
  else
  {
    volatile int i=0;
    for(i=0;i<10;i++);
    
  }
  // Start the AD conversion
  ADCSRA|=0x40;


}












