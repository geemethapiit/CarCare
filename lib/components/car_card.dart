import 'package:flutter/material.dart';
import 'com_button.dart';

class CarCard extends StatelessWidget {
  final String carNumber;
  final String carBrand;
  final String carModel;
  final String carYear;

  const CarCard({
    super.key,
    required this.carNumber,
    required this.carBrand,
    required this.carModel,
    required this.carYear,
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
            Row(
              crossAxisAlignment: CrossAxisAlignment.start,
              children: <Widget>[
                Icon(Icons.directions_car, size: 70),
                SizedBox(width: 16),
                Expanded(
                  child: Column(
                    crossAxisAlignment: CrossAxisAlignment.start,
                    children: <Widget>[
                      Text(
                        "Car Number: $carNumber",
                        style: TextStyle(fontSize: 16, fontWeight: FontWeight.bold),
                      ),
                      SizedBox(height: 4),
                      Text(
                        "Car Brand: $carBrand",
                        style: TextStyle(fontSize: 14),
                      ),
                      SizedBox(height: 4),
                      Text(
                        "Car Model: $carModel",
                        style: TextStyle(fontSize: 14),
                      ),
                      SizedBox(height: 4),
                      Text(
                        "Car Year: $carYear",
                        style: TextStyle(fontSize: 14),
                      ),
                    ],
                  ),
                ),
                Padding(
                  padding: const EdgeInsets.only(top: 90.0),
                  child: ButtonBar(
                    children: <Widget>[
                      ComButton(
                        width: 120,
                        height: 30,
                        title: "Remove",
                        disable: false,
                        color: '#512DA8',
                        onPressed: () => {},
                      ),
                    ],
                  ),
                ),
              ],
            ),
          ],
        ),
      ),
    );
  }
}
