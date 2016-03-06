// 
void USART_Init ();
void USART_SendByte(uint8_t u8Data);
uint8_t USART_ReceiveByte();
uint8_t isTrReady();
#define UBRR_VALUE (((F_CPU / (SERIAL_SPEED * 16UL))) - 1)
