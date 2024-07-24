import 'dart:convert';
import 'package:http/http.dart' as http;
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
    var url = Uri.parse(baseURL + 'auth/register');
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

  static Future<http.Response> login(String email, String password) async {
    Map data = {"email": email, "password": password};
    var body = json.encode(data);
    var url = Uri.parse(baseURL + 'auth/login');
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

  static Future<List<String>> fetchVehicles() async {
    try {
      final token = await getToken();
      final response = await http.get(
        Uri.parse(baseURL + 'vehicles'),
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

  static Future<List<String>> fetchBranches() async {
    final response = await http.get(Uri.parse(baseURL + 'branches'));
    if (response.statusCode == 200) {
      List<dynamic> data = json.decode(response.body);
      print('Branches fetched: $data'); // Debugging
      return data.map((branch) => branch['name'].toString()).toList();
    } else {
      throw Exception('Failed to load branches');
    }
  }

  static Future<List<String>> fetchServices() async {
    final response = await http.get(Uri.parse(baseURL + 'services'));
    if (response.statusCode == 200) {
      List<dynamic> data = json.decode(response.body);
      return data.map((service) => service['ServiceTypeName'].toString()).toList();
    } else {
      throw Exception('Failed to load services');
    }
  }

  static Future<http.Response> vehicleregister(
      String vehicle_number, String brand, String model, String year,) async {
    Map data = {
      "vehicle_number": vehicle_number,
      "brand": brand,
      "model": model,
      "year": year,
    };
    var body = json.encode(data);
    var url = Uri.parse(baseURL + 'vehicles');
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


}
