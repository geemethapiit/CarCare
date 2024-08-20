import 'package:flutter/material.dart';

class ServiceCard extends StatelessWidget {

  final String serviceType;
  final String branch;
  final String usedProducts;
  final String supervisor;
  final String date;
  final String time;

  const ServiceCard({
    super.key,
    required this.serviceType,
    required this.branch,
    required this.usedProducts,
    required this.supervisor,
    required this.date,
    required this.time,
  });


  @override
  Widget build(BuildContext context) {
      return Container(
      width: double.infinity,
          child: Padding(
          padding: const EdgeInsets.all(16.0),
          child: Card(
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
              Text('Service Type : ', style: TextStyle(fontSize: 16, fontWeight: FontWeight.bold),),
              const SizedBox(height: 4),
              Text('Branch: ', style: TextStyle(fontSize: 16, fontWeight: FontWeight.bold),),
              const SizedBox(height: 4),
              Text('Used Products: ', style: TextStyle(fontSize: 16, fontWeight: FontWeight.bold),),
              const SizedBox(height: 4),
              Text('Supervisor : ', style: TextStyle(fontSize: 16, fontWeight: FontWeight.bold),),
              const SizedBox(height: 4),
              Text('Date : ', style: TextStyle(fontSize: 16, fontWeight: FontWeight.bold),),
              const SizedBox(height: 4),
              Text('Time : ', style: TextStyle(fontSize: 16, fontWeight: FontWeight.bold),),
              const SizedBox(height: 4),
            ],
          ),
        ),
          ),
      ),
      );
  }
}
