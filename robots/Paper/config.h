// CONFIG
#define LED_PIN 7
//servo (rotate frontal wheels) 
#define SERVO_PIN 9
#define SERVO_OFFSET 85
#define SERVO_MAX_ANGLE 33
#define STCALC(a) (SERVO_OFFSET+(a)) 

// motor (back wheels are powered)
#define MOTOR_EN 11
#define MOTOR_DIR1 12
#define MOTOR_DIR2 13
#define FORWARD 1
#define STOP 0
#define BACK -1
 
// led
#define LED 5
// distanse (analog sensors)
#define SRIGHT 2
#define SCENTER 0
#define SLEFT 1
// serial
#define SERIAL_SPEED 115200
// button
#define BUTTON 2


//Servo analog output
#define SERVOANALOGPIN 4
#define SERVOLEFTVOLTAGE 47
#define SERVORIGHTVOLTAGE 574


