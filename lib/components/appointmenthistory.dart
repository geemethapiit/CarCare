import 'package:flutter/material.dart';

class HistoryCard extends StatelessWidget {
  final String appointmentID;
  final String serviceType;
  final String branch;
  final String status;
  final String date;
  final String time;

  const HistoryCard({
    super.key,
    required this.appointmentID,
    required this.serviceType,
    required this.branch,
    required this.status,
    required this.date,
    required this.time,
  });

  @override
  Widget build(BuildContext context) {
    return Card(
      color: Colors.white,
      shape: RoundedRectangleBorder(
        borderRadius: BorderRadius.circular(10.0),
        side: BorderSide(color: Colors.grey.shade300, width: 1),
      ),
      child: Padding(
        padding: const EdgeInsets.all(16.0),
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: <Widget>[
            const SizedBox(height: 4),
            Text('Appointment No: $appointmentID', style: TextStyle(fontSize: 16, fontWeight: FontWeight.bold),),
            const SizedBox(height: 4),
            Text('Service Type : $serviceType', style: TextStyle(fontSize: 14, fontWeight: FontWeight.bold),),
            const SizedBox(height: 4),
            Text('Branch: $branch', style: TextStyle(fontSize: 14),),
            const SizedBox(height: 4),
            Text('Status: $status', style: TextStyle(fontSize: 14),),
            const SizedBox(height: 4),
            Text('Date : $date', style: TextStyle(fontSize: 14),),
            const SizedBox(height: 4),
            Text('Time : $time', style: TextStyle(fontSize: 14),),
            const SizedBox(height: 4),
          ],
        ),
      ),
    );
  }
}