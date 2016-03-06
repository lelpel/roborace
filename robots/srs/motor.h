
extern int realRobotSpeed;
extern volatile unsigned char wheelCount;
void motorTick();
unsigned char getSpeed();
void speedInit();
char moveRobot(int value);
void back ();
void getServoInit();
int getServo();
void writeServo (int value );
void setupMotorServo();
void ledSwitch(boolean value);
