// 
void USART_Init ();
extern uint8_t message[];
void transmit_message();
#define SERIAL_ARDUINO
#ifdef SERIAL_ARDUINO
 #define IS_MESSAGE_SEND 1
#else
  void USART_SendByte(uint8_t u8Data);
  uint8_t USART_ReceiveByte();
  void start_transmit();
  extern uint8_t countMes;
  #define UBRR_VALUE (((F_CPU / (SERIAL_SPEED * 16UL))) - 1)
  #define IS_TX_READY ((UCSR0A &(1<<UDRE0)) == 0 ? 1 : 0)
  #define IS_MESSAGE_SEND (IS_TX_READY && (countMes >= sizeof(message)))
#endif
