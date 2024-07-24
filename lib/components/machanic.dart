import 'package:flutter/material.dart';
import 'package:lottie/lottie.dart';



class Machanic extends StatefulWidget {
  const Machanic({super.key});

  @override
  State<Machanic> createState() => _MachanicState();
}

class _MachanicState extends State<Machanic> {
  @override
  Widget build(BuildContext context) {
    return Lottie.asset('assets/lottie/new_Car.json');

  }
}
