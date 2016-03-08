#include <Arduino.h>
#include <avr/io.h>
#include <avr/interrupt.h>
#include "uart.h"
#include "config.h"

uint8_t message[] = {
  'S',
  '1',
  '2',
  '3',
  '4',
  '5', // speed
  '6', // angle
  'E'
};
volatile unsigned char value;  
/* This variable is volatile so both main and RX interrupt can use it.
 It could also be a uint8_t type */

void USART_Init(){
  #ifdef SERIAL_ARDUINO
    Serial.begin(SERIAL_SPEED);
  #else
    cli();
    // Set baud rate
    uint16_t baud_setting;
    uint8_t current_config;
    bool use_u2x = true;
    try_again:
    if (use_u2x) {
      UCSR0A = 1 << U2X0;
      baud_setting = (F_CPU / 4 / SERIAL_SPEED - 1) / 2;
    } else {
      UCSR0A = 0;
      baud_setting = (F_CPU / 8 / SERIAL_SPEED - 1) / 2;
    }  
    if ((baud_setting > 4095) && use_u2x)
    {
      use_u2x = false;
      goto try_again;
    }  
    UBRR0H = baud_setting >> 8;
    UBRR0L = baud_setting;
    // Set frame format to 8 data bits, no parity, 1 stop bit
    UCSR0C |= (1<<UCSZ01)|(1<<UCSZ00);
    // Enable receiver and transmitter and receive complete interrupt 
    UCSR0B = ((1<<TXEN0)|(1<<RXEN0) | (1<<UDRIE0)| (1<<RXCIE0) ); 
    sei();
  #endif
}


#ifdef SERIAL_ARDUINO
  void transmit_message() {
    Serial.write(message,sizeof(message));
  }
#else
  ISR(USART_RXC_vect) { 
    value = UDR0;
  }
  
  uint8_t countMes = 0;
  ISR(USART_UDRE_vect) {
    if(countMes < sizeof(message)) {
      UDR0 = message[countMes++];
    }
  }
  
  void transmit_message() {
    if(IS_MESSAGE_SEND) {
      countMes=1;
      UDR0 = message[0]; 
    }
  }
  
  
  void USART_SendByte(uint8_t u8Data) {
    // Wait until last byte has been transmitted
    while((UCSR0A &(1<<UDRE0)) == 0);
  
    // Transmit data
    UDR0 = u8Data;
  }
  
  // not being used but here for completeness
  // Wait until a byte has been received and return received data 
  uint8_t USART_ReceiveByte(){
    while((UCSR0A &(1<<RXC0)) == 0);
    return UDR0;
  }
#endif




