import 'package:flutter/material.dart';

class BranchCard extends StatelessWidget {
  final String branchId;
  final String branchName;
  final String address;
  final String telephone;

  const BranchCard({
    super.key,
    required this.branchId,
    required this.branchName,
    required this.address,
    required this.telephone,
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
            SizedBox(height: 4),
            Image(image: AssetImage('assets/images/branchnew.jpg'),),
            SizedBox(height: 15),
            Text("Branch ID: $branchId", style: const TextStyle(fontSize: 16, fontWeight: FontWeight.bold)),
            SizedBox(height: 4),
            Text("Branch Name: $branchName", style: const TextStyle(fontSize: 16, fontWeight: FontWeight.bold)),
            SizedBox(height: 4),
            Text("Address: $address", style: const TextStyle(fontSize: 14)),
            SizedBox(height: 4),
            Text("Telephone: $telephone", style: const TextStyle(fontSize: 14)),
            SizedBox(height: 4),
          ],
        ),
      ),
    );
  }
}
