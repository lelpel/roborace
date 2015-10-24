// CONFIG
#define LED_PIN 13
//servo (rotate frontal wheels) 
#define SERVO_PIN 9
#define SERVO_OFFSET 95
#define SERVO_MAX_ANGLE 70
////47
#define STCALC(a) (SERVO_OFFSET+(a)) 
//Servo analog output
#define SERVOANALOGPIN 3
#define SERVOLEFTVOLTAGE 410
#define SERVORIGHTVOLTAGE 294
// motor (back wheels are powered)
#define MOTOR_PIN 10
#define SPEED_FORWARD_MAX   160
#define SPEED_FORWARD_MIN   96
#define SPEED_ZERO          90
#define SPEED_BACK_MIN      84
#define SPEED_BACK_MAX      20
#define REAL_MIN_SPEED      2
// led
#define LED 13
// distanse (analog sensors)
#define SRIGHT 2
#define SLEFTCENTER 1
#define SRIGHTCENTER 3
#define SLEFT 0
// serial
#define SERIAL_SPEED 115200
//
#define BUTTON 12
#define BUT_1 551520375
#define BUT_2 551504055

#define IR_PIN 3
