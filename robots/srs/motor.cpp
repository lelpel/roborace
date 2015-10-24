#include <Arduino.h>
#include <avr/io.h>
#include <avr/interrupt.h>
#include "ADC.h"
#include "setup.h"
#include "config.h"
#include "motor.h"
#include "PWMServo.h"
//#include <Servo.h>

PWMServo motorServoR;
PWMServo wheelServoR;

int realRobotSpeed = 0;

// interrupt
volatile unsigned char wheelCount = 0;
void motorTick() 
{  
  wheelCount++;
}

unsigned long LastTime = 0;
unsigned long NowTime = 0;

unsigned char getSpeed() // mm/s
{
  unsigned char value =  wheelCount; 
  wheelCount = 0;
  return value;
}

void speedInit() //interrupt init pin 2
{
  attachInterrupt(0,motorTick,FALLING);
}

// MOTOR


int lastspeed = 0;

char moveRobot(int value) // -64 break  +64 forward
{  
  value = constrain(value,-64,64); //////////////////////////////////////////////////////////////////////////////////////////////////

  int temp = value;
  if(value>0)
  { 
    if (lastspeed <0) {
      motorServoR.write(SPEED_ZERO);
      lastspeed=value;
      return 0;  
    }
    else
    {
      value = constrain(value+SPEED_FORWARD_MIN, SPEED_FORWARD_MIN, SPEED_FORWARD_MAX);
      motorServoR.write(value);
    }
  }
  else
  {
    if(value<0)
    {
      if((lastspeed!=0)&&(realRobotSpeed>REAL_MIN_SPEED))/////////
      {
        value = constrain(value+SPEED_BACK_MIN, SPEED_BACK_MAX, SPEED_BACK_MIN);
        motorServoR.write(value);
      }
      else 
      {
        motorServoR.write(SPEED_ZERO);  
      }
    }
    else
    {
      motorServoR.write(SPEED_ZERO);
    }
  }

  lastspeed=temp;
  return 1;
}

void back ()
{
  motorServoR.write(SPEED_ZERO);
  delay(700);
  motorServoR.write(SPEED_BACK_MIN);
//  
//  motorServoR.write(SPEED_ZERO-1);
//  delay(50);
//  motorServoR.write(SPEED_ZERO-3);
//  delay(50);
//  motorServoR.write(SPEED_ZERO-5);
//  delay(50);
//  motorServoR.write(SPEED_ZERO-7);
//  //delay(700);//1000 2000 600
//  motorServoR.write(SPEED_BACK_MIN);
}

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

 
void writeServo (int value )
{  
  value = constrain(value,-SERVO_MAX_ANGLE,SERVO_MAX_ANGLE);
  wheelServoR.write(STCALC(value)); 
  
}

void setupMotorServo()
{
  // init moror
  motorServoR.attach(SERVO_PIN_B,544,2400); // 10
  motorServoR.write(SPEED_ZERO);
  delay(3800);
  // initialize the LED pin as an output:
  pinMode(LED,OUTPUT);     

  // init servo and set it to midle
  wheelServoR.attach(SERVO_PIN_A,920,2070);  // 9
  writeServo(0);
}

