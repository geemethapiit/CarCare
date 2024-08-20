import 'dart:developer';

import 'package:carcareproject/components/batteryrecord.dart';
import 'package:carcareproject/components/servicecard.dart';
import 'package:carcareproject/components/tirerecord.dart';
import 'package:carcareproject/screens/service_record.dart';
import 'package:flutter/material.dart';
import 'package:carcareproject/components/luberecord.dart';
import '../Components/config.dart';

class RecordsPage extends StatefulWidget {
  const RecordsPage({super.key});

  @override
  State<RecordsPage> createState() => _RecordsPageState();
}

class _RecordsPageState extends State<RecordsPage> {
  List<bool> isSelected = [true, false, false, false];

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
                margin: EdgeInsets.only(right: 7, left: 7, top: 30),
                width: double.infinity,
                height: 260,
                decoration: BoxDecoration(
                  color: Colors.deepPurple.shade300,
                  borderRadius: BorderRadius.circular(20),
                ),
                child: Padding(
                  padding: const EdgeInsets.all(20.0),
                  child: Column(
                    crossAxisAlignment: CrossAxisAlignment.start,
                    children: [
                      IconButton(
                        icon: Icon(Icons.arrow_back, color: Colors.white),
                        onPressed: () {
                          Navigator.of(context).pop();
                        },
                      ),
                      Text(
                        'Service Records',
                        style: TextStyle(
                          color: Colors.white,
                          fontSize: 30,
                          fontWeight: FontWeight.bold,
                        ),
                      ),
                      Config.spaceSmall,
                      Text(
                        'View your service records here',
                        style: TextStyle(
                          color: Colors.white,
                          fontSize: 20,
                        ),
                      ),
                      Config.spaceSmall,
                      ToggleButtons(
                        children: const <Widget>[
                          Padding(
                            padding: EdgeInsets.symmetric(horizontal: 33.0),
                            child: Text('All'),
                          ),
                          Padding(
                            padding: EdgeInsets.symmetric(horizontal: 33.0),
                            child: Text('Lube'),
                          ),
                          Padding(
                            padding: EdgeInsets.symmetric(horizontal: 33.0),
                            child: Text('Battery'),
                          ),
                          Padding(
                            padding: EdgeInsets.symmetric(horizontal: 33.0),
                            child: Text('Tire'),
                          ),
                        ],
                        isSelected: isSelected,
                        onPressed: (int index) {
                          setState(() {
                            for (int i = 0; i < isSelected.length; i++) {
                              isSelected[i] = i == index;
                            }
                          });
                        },
                        color: Colors.white, // Color of the unselected text
                        selectedColor:
                            Colors.white, // Color of the selected text
                        fillColor: Config
                            .secondaryColor, // Background color of the selected button
                        borderRadius: BorderRadius.circular(8.0),
                        borderColor: Colors.white,
                      ),
                    ],
                  ),
                ),
              ),
              if (isSelected[0]) ...[
               ServiceCard(serviceType: 'Oil', branch: 'branch', usedProducts: 'Mobile', supervisor: "supervisor", date: '2024-08-15', time: "08.20"),
              ] else if (isSelected[1]) ...[
                LubeRecords(),
              ] else if (isSelected[2]) ...[
                BatteryRecord(),
              ] else if (isSelected[3]) ...[
                TireRecord(),
              ],
            ],
          ),
        ),
      ),
    );
  }
}
