import 'package:flutter/material.dart';
import '../Components/com_button.dart';
import '../Components/config.dart';
import '../components/booking_form.dart';
import '../components/ongoing_appointment.dart';
import '../config/auth_services.dart';

class Appointment extends StatefulWidget {
  const Appointment({super.key});

  @override
  State<Appointment> createState() => _AppointmentState();
}

class _AppointmentState extends State<Appointment> {


 void _navigateToBookingForm() async {
    try {
      List<String> branches = await AuthServices.fetchBranches();
      List<String> services = await AuthServices.fetchServices();
      List<String> vehicles = await AuthServices.fetchVehicles();

      Navigator.push(
        context,
        MaterialPageRoute(
          builder: (context) => BookingForm(branches: branches, services: services, vehicles: vehicles),
        ),
      );
    } catch (e) {
      print('Error navigating to BookingForm: $e');
      ScaffoldMessenger.of(context).showSnackBar(SnackBar(
        backgroundColor: Colors.red,
        content: Text('Failed to fetch data for booking'),
      ));
    }
  }


  List<bool> isSelected = [true, false];

  final List<HistoryApp> history = [
    HistoryApp(
      appointment_no: "Ap5001",
      vehicle_no: "CAA-7894",
      service: "Car Wash",
      branch: "Maharagama",
      status: "Done",
      dateTime: DateTime(2024, 07, 20, 10, 0),
    ),
    HistoryApp(
      appointment_no: "Ap5002",
      vehicle_no: "CAB-5678",
      service: "Oil Change",
      branch: "Colombo",
      status: "Done",
      dateTime: DateTime(2024, 07, 21, 11, 0),
    ),
    HistoryApp(
      appointment_no: "Ap5001",
      vehicle_no: "CAA-7894",
      service: "Car Wash",
      branch: "Maharagama",
      status: "Done",
      dateTime: DateTime(2024, 07, 20, 10, 0),
    ),
    HistoryApp(
      appointment_no: "Ap5002",
      vehicle_no: "CAB-5678",
      service: "Oil Change",
      branch: "Colombo",
      status: "Done",
      dateTime: DateTime(2024, 07, 21, 11, 0),
    ),
  ];

  final List<HistoryApp> ongoing = [
    HistoryApp(
      appointment_no: "On5001",
      vehicle_no: "CAA-7894",
      service: "Car Wash",
      branch: "Maharagama",
      status: "Done",
      dateTime: DateTime(2024, 07, 20, 10, 0),
    ),
    HistoryApp(
      appointment_no: "On5002",
      vehicle_no: "CAB-5678",
      service: "Oil Change",
      branch: "Colombo",
      status: "Done",
      dateTime: DateTime(2024, 07, 21, 11, 0),
    ),
    HistoryApp(
      appointment_no: "On5002",
      vehicle_no: "CAB-5678",
      service: "Oil Change",
      branch: "Colombo",
      status: "Done",
      dateTime: DateTime(2024, 07, 21, 11, 0),
    ),
    HistoryApp(
      appointment_no: "On5001",
      vehicle_no: "CAA-7894",
      service: "Car Wash",
      branch: "Maharagama",
      status: "Done",
      dateTime: DateTime(2024, 07, 20, 10, 0),
    ),
    HistoryApp(
      appointment_no: "On5002",
      vehicle_no: "CAB-5678",
      service: "Oil Change",
      branch: "Colombo",
      status: "Done",
      dateTime: DateTime(2024, 07, 21, 11, 0),
    ),
    HistoryApp(
      appointment_no: "On5002",
      vehicle_no: "CAB-5678",
      service: "Oil Change",
      branch: "Colombo",
      status: "Done",
      dateTime: DateTime(2024, 07, 21, 11, 0),
    ),
  ];

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
              width: double.infinity,
              height: 300,
              decoration:  BoxDecoration(
                color: Colors.deepPurple.shade300,
                borderRadius: BorderRadius.only(
                  bottomLeft: Radius.circular(00),
                  bottomRight: Radius.circular(160),
                ),
              ),
              child: Padding(
                padding: const EdgeInsets.symmetric(vertical: 20, horizontal: 30),
                child: Column(
                  mainAxisAlignment: MainAxisAlignment.center,
                  children: [
                    const Text(
                      "Appointments",
                      style: TextStyle(
                        color: Colors.white,
                        fontSize: 24,
                        fontWeight: FontWeight.bold,
                      ),
                    ),
                    Config.spaceSmall,
                    ToggleButtons(
                      isSelected: isSelected,
                      onPressed: (int index) {
                        setState(() {
                          for (int i = 0; i < isSelected.length; i++) {
                            isSelected[i] = i == index;
                          }
                        });
                      },
                      color: Colors.white, // Color of the unselected text
                      selectedColor: Colors.white, // Color of the selected text
                      fillColor: Config.secondaryColor, // Background color of the selected button
                      borderRadius: BorderRadius.circular(8.0),
                      borderColor: Colors.white,
                      children: const <Widget>[
                        Padding(
                          padding: EdgeInsets.symmetric(horizontal: 50.0),
                          child: Text('Ongoing'),
                        ),
                        Padding(
                          padding: EdgeInsets.symmetric(horizontal: 50.0),
                          child: Text('History'),
                        ),
                      ],
                    ),
                    Config.spaceSmall,
                    Config.spaceSmall,
                    ComButton(
                      width: 300,
                      title: "Book Your Service Now",
                      disable: false,
                      color: '#512DA8',
                      onPressed: _navigateToBookingForm,
                      height: 50,
                    ),
                  ],
                ),
              ),
            ),
            Config.spaceSmall,
            Container(
              width: double.infinity,
              padding: EdgeInsets.all(10),
              decoration: BoxDecoration(),
              child: Column(
                children: [
                  ListView.builder(
                    physics: NeverScrollableScrollPhysics(),
                    shrinkWrap: true,
                    itemCount: isSelected[0] ? ongoing.length : history.length,
                    itemBuilder: (context, index) {
                      final app = isSelected[0] ? ongoing[index] : history[index];
                      return Card(
                        margin: EdgeInsets.symmetric(vertical: 10),
                        child: ListTile(
                          title: Text("Appointment No: ${app.appointment_no}"),
                          subtitle: Column(
                            crossAxisAlignment: CrossAxisAlignment.start,
                            children: [
                              Text("Vehicle No: ${app.vehicle_no}"),
                              Text("Service: ${app.service}"),
                              Text("Branch: ${app.branch}"),
                              Text("Status: ${app.status}"),
                              Text("Date & Time: ${app.dateTime}"),
                            ],
                          ),
                        ),
                      );
                    },
                  ),
                ],
              ),
            ),
          ],
        ),
      ),
        ),
    );
  }
}

