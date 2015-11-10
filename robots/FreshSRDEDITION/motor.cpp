#include <Arduino.h>
#include <avr/io.h>
#include <avr/interrupt.h>
#include "ADC.h"
#include "setup.h"
#include "config.h"
#include "motor.h"
#include "PWMServo.h"
#include <Servo.h>

// MOTOR

char motorDir = STOP; // 1 forward 0 stop -1 back
void motorInit()
{
  pinMode(MOTOR_DIR,OUTPUT);
  pinMode(MOTOR_EN,OUTPUT);
}
void forward(int value)
{
  motorDir=FORWARD;
  digitalWrite(MOTOR_DIR,HIGH);
  value=constrain(value,0,255);
  analogWrite(MOTOR_EN,value);
}
void neutral()
{
  motorDir=STOP;
  analogWrite(MOTOR_EN,0);
}
void back(int value)
{ 
  motorDir=BACK;
  digitalWrite(MOTOR_DIR,LOW);
  value=constrain(value,0,255);
  analogWrite(MOTOR_EN,value);
}


// speed of robot
unsigned long tPrev = 0; // time of previev interrupt it use for "drebezg"
unsigned long tCurr = 0; // time current interrupt it use for "drebezg"
int state = HIGH; // for led 


//Servo analog output
#define SERVOANALOGPIN 7
#define SERVOMINVOLTAGE 47
#define SERVOMAXVOLTAGE 574



// SERVO
void getServoInit()
{
  pinMode(SERVOANALOGPIN,INPUT);
  digitalWrite(SERVOANALOGPIN,HIGH);
}
int getServo() //return servo
{
  int value = map(adc_data[SERVOANALOGPIN],SERVOLEFTVOLTAGE,SERVORIGHTVOLTAGE,-SERVO_MAX_ANGLE,SERVO_MAX_ANGLE)+7;
  return value;
}

Servo wheelServoR; 
void writeServo (int value )
{  
  value = constrain(value,-SERVO_MAX_ANGLE,SERVO_MAX_ANGLE);
  wheelServoR.write(STCALC(value)); 
  
}

void setupMotorServo()
{
  // init moror
   motorInit();
  //motorServoR.attach(SERVO_PIN_B,544,2400); // 10
  //motorServoR.write(SPEED_ZERO);
  //delay(3200);
  // initialize the LED pin as an output:
  pinMode(LED,OUTPUT);     

  // init servo and set it to midle
  wheelServoR.attach(SERVO_PIN_A,500,2500);  // 9
  writeServo(0);
}

