import 'package:flutter/material.dart';
import 'dart:convert';
import 'package:http/http.dart' as http;
import '../components/car_card.dart';
import '../Components/config.dart';
import '../components/vehicle_application.dart';
import '../config/auth_services.dart';
import '../config/global.dart';

class Vehicles extends StatefulWidget {
  const Vehicles({super.key});

  @override
  State<Vehicles> createState() => _VehiclesState();
}

class _VehiclesState extends State<Vehicles> {
  List<dynamic> vehicles = [];
  bool isLoading = true;

  @override
  void initState() {
    super.initState();
    fetchVehicles();
  }

  Future<void> fetchVehicles() async {
    try {
      final token = await AuthServices.getToken();
      final response = await http.get(
        Uri.parse(baseURL + 'vehicles'), // Replace with your API endpoint
        headers: {
          'Authorization': 'Bearer $token',
          'Content-Type': 'application/json',
        },
      );

      if (response.statusCode == 200) {
        setState(() {
          vehicles = json.decode(response.body);
          isLoading = false;
        });
      } else {
        throw Exception('Failed to load vehicles');
      }
    } catch (e) {
      print('Error fetching vehicles: $e');
      setState(() {
        isLoading = false;
      });
    }
  }


  void _addNewVehicle() {
    showModalBottomSheet(
      context: context,
      isScrollControlled: true,
      builder: (BuildContext context) {
        return Padding(
          padding: EdgeInsets.only(
            bottom: MediaQuery.of(context).viewInsets.bottom,
          ),
          child: SingleChildScrollView(
            child: Container(
              padding: EdgeInsets.all(16.0),
              child: VehicleApplication(),
            ),
          ),
        );
      },
    );
  }



  @override
  Widget build(BuildContext context) {
    return Container(
        decoration: Config.gradientBackground,
        child: Scaffold(
            backgroundColor: Colors.transparent,
            appBar: PreferredSize(
              preferredSize: Size.fromHeight(120.0),
              child: AppBar(
                backgroundColor: Colors.deepPurple.shade400,
                elevation: 0,
                flexibleSpace: Center(
                  child: Padding(
                    padding: const EdgeInsets.only(top: 40.0),
                    child: Text(
                      'Your Vehicles',
                      style: TextStyle(
                        fontSize: 24,
                        fontWeight: FontWeight.bold,
                        color: Colors.white,
                      ),
                    ),
                  ),
                ),
              ),
            ),
            body: isLoading
                ? Center(child: CircularProgressIndicator())
                : Padding(
                    padding: EdgeInsets.only(top: 20, left: 20, right: 20),
                    child: ListView.builder(
                      itemCount: vehicles.length,
                      itemBuilder: (context, index) {
                        final vehicle = vehicles[index];
                        return CarCard(
                          carNumber: vehicle['vehicle_number'] ?? 'N/A',
                          carBrand: vehicle['brand'] ?? 'N/A',
                          carModel: vehicle['model'] ?? 'N/A',
                          carYear: vehicle['year'] ?? 0,
                        );
                      },
                    ),
                  ),
          floatingActionButton:SizedBox(
            width: 70,
          height: 70,
          child:FloatingActionButton(
            onPressed: _addNewVehicle,
            shape: RoundedRectangleBorder(
              borderRadius: BorderRadius.circular(46.0), // Set border radius
            ),
            child: Icon(
              Icons.add,
              size: 30.0,
            ),
            backgroundColor: Colors.deepPurple.shade400,
          ),)));
  }
}
