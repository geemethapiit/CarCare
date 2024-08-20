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
        Uri.parse(baseURL + '/vehicles'),
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


  Future<void> deleteVehicle(String vehicleNumber) async {
    try {
      final token = await AuthServices.getToken();
      final url = Uri.parse('$baseURL/vehicles/$vehicleNumber');
      final response = await http.delete(
        url,
        headers: {
          'Authorization': 'Bearer $token',
          'Content-Type': 'application/json',
        },
      );

      if (response.statusCode == 200 || response.statusCode == 204) {
        setState(() {
          vehicles.removeWhere((vehicle) => vehicle['vehicle_number'] == vehicleNumber);
        });
        ScaffoldMessenger.of(context).showSnackBar(
          SnackBar(content: Text('Vehicle removed successfully')),
        );
      } else {
        throw Exception('Failed to delete vehicle');
      }
    } catch (e) {
      print('Error deleting vehicle: $e');
      ScaffoldMessenger.of(context).showSnackBar(
        SnackBar(content: Text('Failed to delete vehicle')),
      );
    }
  }

  Future<void> _confirmDelete(String vehicleNumber) async {
    final result = await showDialog<bool>(
      context: context,
      builder: (context) => AlertDialog(
        title: Text('Confirm Deletion'),
        content: Text('Are you sure you want to remove this vehicle?'),
        actions: [
          TextButton(
            onPressed: () => Navigator.of(context).pop(false), // Cancel
            child: Text('Cancel'),
          ),
          ElevatedButton(
            onPressed: () => Navigator.of(context).pop(true), // Confirm
            child: Text('Remove'),
            style: ElevatedButton.styleFrom(
              backgroundColor: Colors.red, // Optional: Change button color
            ),
          ),
        ],
      ),
    );

    if (result == true) {
      deleteVehicle(vehicleNumber); // Call the delete function if confirmed
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
                  carModel: vehicle['model'] ?? 'N/A',
                  carYear: vehicle['year'].toString(), // Ensure carYear is a String
                  onRemove: () => _confirmDelete(vehicle['vehicle_number']),
                );
              },
            ),
          ),
          floatingActionButton: SizedBox(
            width: 70,
            height: 70,
            child: FloatingActionButton(
              onPressed: _addNewVehicle,
              shape: RoundedRectangleBorder(
                borderRadius: BorderRadius.circular(46.0),
              ),
              child: Icon(
                Icons.add,
                size: 30.0,
              ),
              backgroundColor: Colors.deepPurple.shade400,
            ),
          ),
        ));
  }
}
