import 'package:flutter/material.dart';

import '../Components/config.dart';

class NotificationPage extends StatefulWidget {
  const NotificationPage({super.key});

  @override
  State<NotificationPage> createState() => _NotificationPageState();
}

class _NotificationPageState extends State<NotificationPage> {
  @override
  Widget build(BuildContext context) {
    return Container(
      decoration: Config.gradientBackground,
        child: Scaffold(
      backgroundColor: Colors.transparent,
          body: SingleChildScrollView(
            child: Column(
              children: [
                Container(
                  margin: const EdgeInsets.only(right: 7, left: 7, top: 30),
                  width: double.infinity,
                  height: 80,
                  decoration: BoxDecoration(
                    color: Colors.deepPurple.shade300,
                    borderRadius: BorderRadius.circular(20),
                  ),
                 child: Padding(
                   padding: const EdgeInsets.symmetric(horizontal: 10, vertical: 10),
                   child: Column(
                     mainAxisAlignment: MainAxisAlignment.center,
                     children: [
                        const Text(
                          'Notifications',
                          style: TextStyle(
                            color: Colors.white,
                            fontSize: 30,
                            fontWeight: FontWeight.bold,
                          ),
                        ),
                     ],
                   ),
                 ),
                ),

              ],
            ),
          ),
        ),
    );
  }
}
