#include <Arduino.h>
#include <avr/io.h>
#include <avr/interrupt.h>
#include "uart.h"
#include "config.h"

volatile unsigned char value;  
/* This variable is volatile so both main and RX interrupt can use it.
It could also be a uint8_t type */

void USART_Init(){
  // Set baud rate
  UBRR0H = (uint8_t)(UBRR_VALUE>>8);
  UBRR0L = (uint8_t)UBRR_VALUE;
  // Set frame format to 8 data bits, no parity, 1 stop bit
  UCSR0C |= (1<<UCSZ01)|(1<<UCSZ00);
  // Enable receiver and transmitter and receive complete interrupt 
  UCSR0B = ((1<<TXEN0)|(1<<RXEN0) | (1<<RXCIE0));
}



/* Interrupt Service Routine for Receive Complete 
NOTE: vector name changes with different AVRs see AVRStudio -
Help - AVR-Libc reference - Library Reference - <avr/interrupt.h>: Interrupts
for vector names other than USART_RXC_vect for ATmega32 */

ISR(USART_RXC_vect){ 
   value = UDR0;             //read UART register into value
}




void USART_SendByte(uint8_t u8Data){
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


//
//int main(void){
//   USART_Init();  // Initialise USART
//   sei();         // enable all interrupts
//   Led_init();    // init LEDs for testing
//   value = 'A'; //0x41;    
//   PORTB = ~value; // 0 = LED on
//   
//   for(;;){    // Repeat indefinitely
//             
//     USART_SendByte(value);  // send value 
//     _delay_ms(250);         
//		         // delay just to stop Hyperterminal screen cluttering up    
//   }
//}
