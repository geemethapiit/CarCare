import 'dart:convert';
import 'package:http/http.dart' as http;
import 'package:intl/intl.dart';
import 'global.dart';
import 'package:flutter_secure_storage/flutter_secure_storage.dart';

class AuthServices {
  static final FlutterSecureStorage storage = const FlutterSecureStorage();

  static Future<void> saveToken(String token) async {
    await storage.write(key: 'auth_token', value: token);
  }

  static Future<String?> getToken() async {
    final token = await storage.read(key: 'auth_token');
    print('Retrieved token: $token'); // Debugging
    return token;
  }

  static Future<void> deleteToken() async {
    await storage.delete(key: 'auth_token');
  }


  // register function
  static Future<http.Response> register(
      String name, String email, String password, String address, String phoneNo) async {
    Map data = {
      "name": name,
      "email": email,
      "password": password,
      "address": address,
      "phoneNo": phoneNo,
    };
    var body = json.encode(data);
    var url = Uri.parse(baseURL + '/auth/register');
    http.Response response = await http.post(
      url,
      headers: {'Content-Type': 'application/json'},
      body: body,
    );
    print('Request Body: $body'); // Debugging
    print('Response Body: ${response.body}'); // Debugging
    print('Response Status Code: ${response.statusCode}'); // Debugging
    return response;
  }


  // login function
  static Future<http.Response> login(String email, String password) async {
    Map data = {"email": email, "password": password};
    var body = json.encode(data);
    var url = Uri.parse(baseURL + '/auth/login');
    print('Login request to $url with body $body');  // Debugging

    http.Response response = await http.post(
      url,
      headers: {'Content-Type': 'application/json'},
      body: body,
    );

    print('Login response status: ${response.statusCode}');  // Debugging
    print('Login response body: ${response.body}');  // Debugging

    if (response.statusCode == 200) {
      var responseBody = json.decode(response.body);
      print('Token: ${responseBody['token']}');  // Debugging
      await saveToken(responseBody['token']);
    }

    return response;
  }


  // fetch vehicles function
  static Future<List<String>> fetchVehicles() async {
    try {
      final token = await getToken();
      final response = await http.get(
        Uri.parse(baseURL + '/vehicles'),
        headers: {
          'Authorization': 'Bearer $token',
        },
      );
      print('Response: ${response.body}'); // Debugging
      if (response.statusCode == 200) {
        List<dynamic> data = json.decode(response.body);
        return data.map((vehicle) => vehicle['vehicle_number'].toString()).toList();
      } else {
        throw Exception('Failed to load vehicles. Status code: ${response.statusCode}');
      }
    } catch (e) {
      print('Error fetching vehicles: $e');
      throw e;
    }
  }


  // fetch branches function
  static Future<List<Map<String, String>>> fetchBranches() async {
    final response = await http.get(Uri.parse(baseURL + '/branches'));
    if (response.statusCode == 200) {
      List<dynamic> data = json.decode(response.body);
      print('Branches fetched: $data'); // Debugging
      // Return a list of maps with branch names and IDs
      return data.map((branch) => {
        'name': branch['name'].toString(),
        'id': branch['BranchID'].toString(),
      }).toList();
    } else {
      throw Exception('Failed to load branches');
    }
  }


  // fetch services function
  static Future<List<Map<String, String>>> fetchServices() async {
    final response = await http.get(Uri.parse(baseURL + '/services'));
    if (response.statusCode == 200) {
      List<dynamic> data = json.decode(response.body);
      return data.map((service) => {
        'ServiceTypeName': service['ServiceTypeName'].toString(),
        'ServiceTypeID': service['ServiceTypeID'].toString()
      }).toList();
    } else {
      throw Exception('Failed to load services');
    }
  }


  // vehicle registration function
  static Future<http.Response> vehicleregister(
      String vehicle_number, String model, int year) async {
    final token = await getToken();
    Map data = {
      "vehicle_number": vehicle_number,
      "model": model,
      "year": year,
    };
    var body = json.encode(data);
    var url = Uri.parse(baseURL + '/vehicles');
    http.Response response = await http.post(
      url,
      headers: {
        'Content-Type': 'application/json',
        'Authorization': 'Bearer $token',
      },
      body: body,
    );
    print('Request Body: $body'); // Debugging
    print('Response Body: ${response.body}'); // Debugging
    print('Response Status Code: ${response.statusCode}'); // Debugging
    return response;
  }


  // delete vehicle function
  static Future<http.Response> deleteVehicle(String vehicleNumber) async {
    final token = await getToken();
    final response = await http.delete(
      Uri.parse('$baseURL/vehicles/$vehicleNumber'),
      headers: {
        'Authorization': 'Bearer $token',
        'Content-Type': 'application/json',
      },
    );
    print('Delete response status: ${response.statusCode}');  // Debugging
    print('Delete response body: ${response.body}');  // Debugging
    return response;
  }



// fetch appointment history function
  static Future<List<Map<String, String>>> fetchAppointmentHistory() async {
    try {
      final token = await getToken();
      final response = await http.get(
        Uri.parse(baseURL + '/appointments/history'),
        headers: {
          'Authorization': 'Bearer $token',
          'Content-Type': 'application/json',
        },
      );

      if (response.statusCode == 200) {
        // Decode the JSON response
        Map<String, dynamic> jsonResponse = json.decode(response.body);

        // Log the structure of the response
        print('Decoded JSON: $jsonResponse');

        // Extract the 'appointments' list
        if (jsonResponse.containsKey('appointments')) {
          List<dynamic> appointments = jsonResponse['appointments'];

          // Map the appointments to the expected structure
          return appointments.map((appointment) {
            return {
              'appointmentID': appointment['id'].toString(),
              'Vehicle No': appointment['vehicle_no'].toString(),
              'date': appointment['date'].toString(),
              'time': appointment['time'].toString(),
              'status': appointment['status'].toString(),
              'serviceType': appointment['service_type'].toString(),
              'branch': appointment['branch'].toString(),
            };
          }).toList();
        } else {
          print('Error: "appointments" key not found in JSON response.');
          throw Exception('Invalid response structure');
        }
      } else {
        print('Error: Server responded with status code ${response.statusCode}');
        throw Exception('Failed to load appointment history');
      }
    } catch (e) {
      print('Error in fetchAppointmentHistory: $e');
      throw Exception('An error occurred while fetching appointment history');
    }
  }

  // fetch ongoing appointments function
  static Future<List<Map<String, String>>> fetchOngoingAppointments() async {
    try {
      final token = await getToken();
      final response = await http.get(
        Uri.parse(baseURL + '/appointments/upcoming'),
        headers: {
          'Authorization': 'Bearer $token',
          'Content-Type': 'application/json',
        },
      );

      if (response.statusCode == 200) {
        // Decode the JSON response
        Map<String, dynamic> jsonResponse = json.decode(response.body);

        // Log the structure of the response
        print('Decoded JSON: $jsonResponse');

        // Extract the 'appointments' list
        if (jsonResponse.containsKey('appointments')) {
          List<dynamic> appointments = jsonResponse['appointments'];

          // Map the appointments to the expected structure
          return appointments.map((appointment) {
            return {
              'appointmentID': appointment['id'].toString(),
              'Vehicle No': appointment['vehicle_no'].toString(),
              'date': appointment['date'].toString(),
              'time': appointment['time'].toString(),
              'status': appointment['status'].toString(),
              'serviceType': appointment['service_type'].toString(),
              'branch': appointment['branch'].toString(),
            };
          }).toList();
        } else {
          print('Error: "appointments" key not found in JSON response.');
          throw Exception('Invalid response structure');
        }
      } else {
        print('Error: Server responded with status code ${response.statusCode}');
        throw Exception('Failed to load ongoing appointments');
      }
    } catch (e) {
      print('Error in fetchOngoingAppointments: $e');
      throw Exception('An error occurred while fetching ongoing appointments');
    }
  }



  // fetch available time slots function
  static Future<List<String>> fetchAvailableTimeSlots(String branchID, DateTime date) async {
    print(branchID);

    String formattedDate = DateFormat('yyyy-MM-dd').format(date);
    print(formattedDate);

    final token = await AuthServices.getToken();
    final response = await http.get(
      Uri.parse('$baseURL/available-time-slots?date=${Uri.encodeComponent(formattedDate)}&BranchID=$branchID'),
      headers: {
        'Authorization': 'Bearer $token',
        'Content-Type': 'application/json',
      },
    );

    print('$baseURL/available-time-slots?date=${Uri.encodeComponent(formattedDate)}&BranchID=$branchID');

    if (response.statusCode == 200) {
      final data = json.decode(response.body);
      print('Available slots: $data'); // Debugging
      return List<String>.from(data['available_slots']);
    } else {
      // Log the error details
      print('Error fetching slots: ${response.statusCode}');
      print('Response body: ${response.body}');
      throw Exception('Failed to load available time slots');
    }
  }

  void sendDate() {
    DateTime date = DateTime.parse('2024-08-20T00:00:00.000');
    String formattedDate = DateFormat('yyyy-MM-dd').format(date);
    print(formattedDate);
  }


  // show branch details
  static Future<List<Map<String, String>>> fetchBranchesDetails() async {
    final response = await http.get(Uri.parse(baseURL + '/branches/details'));
    if (response.statusCode == 200) {
      List<dynamic> data = json.decode(response.body);
      print('Branches fetched: $data'); // Debugging
      // Return a list of maps with branch names and IDs
      return data.map((branch) => {
        'id': branch['BranchID'].toString(),
        'name': branch['name'].toString(),
        'address': branch['address'].toString(),
        'telephone': branch['telephone'].toString(),
      }).toList();
    } else {
      throw Exception('Failed to load branches');
    }
  }
}

