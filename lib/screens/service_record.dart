import 'package:flutter/material.dart';

import '../Components/config.dart';


class ServiceRecord extends StatefulWidget {
  const ServiceRecord({super.key});

  @override
  State<ServiceRecord> createState() => _ServiceRecordState();
}

class _ServiceRecordState extends State<ServiceRecord> {
  @override
  Widget build(BuildContext context) {
    return Container(
      decoration: Config.gradientBackground,
      child: Scaffold(
        backgroundColor: Colors.transparent,
      )
    );
  }
}
