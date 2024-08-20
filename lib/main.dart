import 'package:carcareproject/components/splash_screen.dart';
import 'package:carcareproject/screens/vehicles.dart';
import 'package:flutter/material.dart';
import 'components/bottom_navigation.dart';
import 'components/config.dart';
import 'components/feedbackform.dart';

void main(){
  runApp(const MyApp());
}

class MyApp extends StatelessWidget {
  const MyApp({super.key});


  @override
  Widget build(BuildContext context) {
    return MaterialApp(
      debugShowCheckedModeBanner: false,
      title: 'Car Service',
      theme: ThemeData(
          inputDecorationTheme: const InputDecorationTheme(
            focusColor: Config.primaryColor,
            border: Config.outlinedBorder,
            focusedBorder: Config.focusBorder,
            errorBorder: Config.errorBorder,
            enabledBorder: Config.outlinedBorder,
            floatingLabelStyle: TextStyle(color: Config.primaryColor),
            prefixIconColor: Colors.black38,
          ),
          scaffoldBackgroundColor: Colors.white,
          bottomNavigationBarTheme: BottomNavigationBarThemeData(
            backgroundColor: Config.primaryColor,
            selectedItemColor: Colors.white,
            showSelectedLabels: true,
            showUnselectedLabels: false,
            unselectedItemColor: Colors.grey.shade700,
            elevation: 10,
            type: BottomNavigationBarType.fixed,
          )
      ),
      initialRoute: '/',
      routes: {
        // Welcome page
        '/' : (context) => SplashScreen(),
        //for main layout after login
        '/main': (context) => CustomBottomNavBar(),
        //for car page
        '/car': (context) => Vehicles(),
      },
    );
  }
}
