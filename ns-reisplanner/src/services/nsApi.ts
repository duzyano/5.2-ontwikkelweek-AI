import axios from 'axios';
import { Station, Route, ApiResponse } from '../types';

const API_KEY = process.env.REACT_APP_NS_API_KEY;
const BASE_URL = 'https://gateway.apiportal.ns.nl/reisinformatie-api/api/v2';

const api = axios.create({
  baseURL: BASE_URL,
  headers: {
    'Ocp-Apim-Subscription-Key': API_KEY
  }
});

export const getStations = async (): Promise<Station[]> => {
  try {
    const response = await api.get('/stations');
    return response.data.payload.map((station: any) => ({
      name: station.names.long,
      code: station.stationCode
    }));
  } catch (error) {
    console.error('Error fetching stations:', error);
    return [];
  }
};

export const getTripAdvice = async (
  from: string,
  to: string,
  datetime: string,
  isArrival: boolean
): Promise<Route[]> => {
  try {
    const response = await api.get('/trip-advices', {
      params: {
        fromStation: from,
        toStation: to,
        [isArrival ? 'plannedArrivalTime' : 'plannedDepartureTime']: datetime
      }
    });

    return response.data.trips.map((trip: any) => ({
      vertrekTijd: trip.legs[0].origin.plannedDateTime,
      aankomstTijd: trip.legs[trip.legs.length - 1].destination.plannedDateTime,
      reistijd: `${Math.floor(trip.plannedDurationInMinutes / 60)}u ${trip.plannedDurationInMinutes % 60}m`,
      overstappen: trip.transfers,
      treinType: trip.legs[0].product.categoryCode,
      perron: trip.legs[0].origin.plannedTrack,
      tussenstations: trip.legs.map((leg: any) => leg.destination.name).slice(0, -1),
      prijs: '€ --,--', // Prijzen zijn niet beschikbaar via de openbare API
      vertrekVertraging: trip.legs[0].origin.actualDateTime ? 
        Math.floor((new Date(trip.legs[0].origin.actualDateTime).getTime() - 
                   new Date(trip.legs[0].origin.plannedDateTime).getTime()) / 60000) : 0
    }));
  } catch (error) {
    console.error('Error fetching trip advice:', error);
    return [];
  }
};