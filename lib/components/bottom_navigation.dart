import 'package:carcareproject/screens/appointment.dart';
import 'package:carcareproject/screens/home_page.dart';
import 'package:carcareproject/screens/notification.dart';
import 'package:carcareproject/screens/profile_page.dart'; // Ensure this import is correct
import 'package:curved_navigation_bar/curved_navigation_bar.dart';
import 'package:flutter/material.dart';
import 'config.dart';


class CustomBottomNavBar extends StatefulWidget {
  const CustomBottomNavBar({Key? key}) : super(key: key);

  @override
  State<CustomBottomNavBar> createState() => CustomBottomNavBarState();
}

class CustomBottomNavBarState extends State<CustomBottomNavBar> {
  int _selectedIndex = 0;

  final PageController _pageController = PageController(initialPage: 0);

  @override
  Widget build(BuildContext context) {
    return Container(
      decoration: Config.gradientBackground,
      child: Scaffold(
        backgroundColor: Colors.transparent,
        bottomNavigationBar: CurvedNavigationBar(
          backgroundColor: Colors.transparent,
          color: Colors.deepPurple.shade300,
          animationDuration: const Duration(milliseconds: 100),
          onTap: (index) {
            setState(() {
              _selectedIndex = index;
              _pageController.jumpToPage(index);
            });
          },
          items: const <Widget>[
            Icon(Icons.home, color: Colors.white, size: 30),
            Icon(Icons.calendar_today, color: Colors.white, size: 30),
            Icon(Icons.notifications, color: Colors.white, size: 30),
            Icon(Icons.person, color: Colors.white, size: 30),
            // Add any new icons here
          ],
        ),
        body: PageView(
          controller: _pageController,
          onPageChanged: (index) {
            setState(() {
              _selectedIndex = index;
            });
          },
          children: [
            HomePage(),
            Appointment(),
            NotificationPage(),
            ProfilePage(),
            // Add any new pages here
          ],
        ),
      ),
    );
  }
}
