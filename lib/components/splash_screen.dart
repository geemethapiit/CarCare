import 'package:carcareproject/components/com_button.dart';
import 'package:flutter/material.dart';
import 'package:lottie/lottie.dart';
import 'package:carcareproject/screens/sign_up_page.dart';
import '../screens/login_page.dart';
import 'config.dart';


class SplashScreen extends StatefulWidget {
  const SplashScreen({super.key});

  @override
  State<SplashScreen> createState() => _SplashScreenState();
}

class _SplashScreenState extends State<SplashScreen> {
  @override
  Widget build(BuildContext context) {
    return Container(
      decoration: Config.gradientBackground,
      child: Scaffold(
        backgroundColor: Colors.transparent,
        body: SafeArea(
          child: Column(
            mainAxisAlignment: MainAxisAlignment.center,
            children: [
              Center(
                child: Lottie.asset('assets/lottie/new_Car.json'),
              ),
              Container(// Assuming you want a background color
                child: Column(
                  mainAxisAlignment: MainAxisAlignment.end,
                  children: [
                    Image.asset(
                      'assets/images/logo_new.png',
                    ),
                    Config.spaceSmall,
                    ComButton(
                      width: 350,
                      height: 60,
                      title: "SIGN UP",
                      disable: false,
                      color: '#512DA8',
                      onPressed: () {
                        Navigator.push(
                          context,
                          MaterialPageRoute(
                            builder: (context) => SignUpPage(),
                          ),
                        );
                      },
                    ),
                    Config.spaceSmall,
                    Config.spaceSmall,
                    ComButton(
                      width: 350,
                      height: 60,
                      title: "LOGIN",
                      disable: false,
                      color: '#512DA8',
                      onPressed: () {
                        Navigator.push(
                          context,
                          MaterialPageRoute(
                            builder: (context) => LoginPage(),
                          ),
                        );
                      },
                    ),
                  ],
                ),
              )
            ],
          ),
        ),
      ),
    );
  }
}
