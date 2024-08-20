import 'package:carcareproject/components/config.dart';
import 'package:carcareproject/screens/records.dart';
import 'package:flutter/material.dart';
import 'package:carcareproject/components/com_button.dart';

class CarCard extends StatelessWidget {
  final String carNumber;
  final String carModel;
  final String carYear;
  final VoidCallback onRemove;

  const CarCard({
    super.key,
    required this.carNumber,
    required this.carModel,
    required this.carYear,
    required this.onRemove,
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
                        "Car Brand & Model: $carModel",
                        style: TextStyle(fontSize: 14),
                      ),
                      SizedBox(height: 4),
                      Text(
                        "Car Year: $carYear",
                        style: TextStyle(fontSize: 14),
                      ),
                      Config.spaceSmall,
                      Row(
                        children: [
                          ButtonBar(
                            children: <Widget>[
                              ComButton(
                                width: 120,
                                height: 30,
                                title: "Records",
                                disable: false,
                                color: '#512DA8',
                                onPressed: () {
                                  Navigator.push(context, MaterialPageRoute(builder: (context) => RecordsPage()),);
                                },
                              ),
                              ComButton(
                                width: 120,
                                height: 30,
                                title: "Remove",
                                disable: false,
                                color: '#FF0000',
                                onPressed: () {
                                  print('Removing vehicle with number: $carNumber'); // Debugging
                                  onRemove();
                                },
                              ),
                            ],
                          ),
                        ],
                      )
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
