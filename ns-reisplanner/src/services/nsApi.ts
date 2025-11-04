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
      import axios from 'axios';
      import { Route } from '../types';

      const API_KEY = process.env.REACT_APP_NS_API_KEY || '';
      const BASE_URL = 'https://gateway.apiportal.ns.nl/reisinformatie-api/api/v2';

      // If no API key is present we fall back to simulated data so the app still works
      const api = axios.create({
        baseURL: BASE_URL,
        headers: API_KEY ? { 'Ocp-Apim-Subscription-Key': API_KEY } : {}
      });

      export const getStations = async (): Promise<string[]> => {
        if (!API_KEY) {
          // return list of hardcoded stations (same as component)
          return [
            'Amsterdam Centraal', 'Amsterdam Sloterdijk', 'Amsterdam Zuid', 'Amsterdam Amstel',
            'Rotterdam Centraal', 'Rotterdam Alexander', 'Rotterdam Blaak',
            'Den Haag Centraal', 'Den Haag HS', 'Den Haag Laan van NOI',
            'Utrecht Centraal', 'Utrecht Overvecht', 'Utrecht Zuilen',
            'Eindhoven Centraal', 'Eindhoven Strijp-S',
            'Groningen', 'Groningen Europapark',
            'Maastricht', 'Maastricht Randwyck',
            'Arnhem Centraal', 'Nijmegen', 'Nijmegen Goffert',
            'Breda', 'Tilburg', 'Haarlem', 'Leiden Centraal',
            'Delft', 'Gouda', 'Amersfoort Centraal', 'Zwolle',
            'Enschede', 'Almere Centrum', 'Lelystad Centrum',
            'Schiphol Airport', 'Zaandam', 'Alkmaar',
            'Hoorn', 'Den Bosch', 'Venlo', 'Roosendaal'
          ];
        }

        try {
          const res = await api.get('/stations');
          // Map to simple array of station names if API returns expected payload
          if (res.data && res.data.payload) {
            return res.data.payload.map((s: any) => s.names?.long || s.name || s.stationCode);
          }
          return [];
        } catch (err) {
          console.error('Error fetching stations from NS API', err);
          return [];
        }
      };

      export const getTripAdvice = async (from: string, to: string, datetime: string, isArrival = false): Promise<Route[]> => {
        if (!API_KEY) {
          // Simulate 3 routes when no API key is provided
          const simulateRoute = (offsetMin: number): Route => {
            const base = new Date(datetime);
            base.setMinutes(base.getMinutes() + offsetMin);
            const vertrek = new Date(base);
            const travel = 40 + Math.floor(Math.random() * 80);
            const aankomst = new Date(vertrek.getTime() + travel * 60000);
            return {
              vertrekTijd: vertrek.toTimeString().slice(0,5),
              aankomstTijd: aankomst.toTimeString().slice(0,5),
              reistijd: `${Math.floor(travel/60)}u ${travel%60}m`,
              overstappen: Math.floor(Math.random()*3),
              treinType: ['Intercity','Sprinter','Intercity Direct'][Math.floor(Math.random()*3)],
              perron: `${Math.floor(Math.random()*12)+1}${Math.random()>0.5?'a':'b'}`,
              tussenstations: [],
              prijs: `€ ${(8 + Math.random()*30).toFixed(2)}`,
              vertrekVertraging: Math.random()>0.8?Math.floor(Math.random()*10)+1:0
            };
          };

          return [simulateRoute(0), simulateRoute(20), simulateRoute(40)];
        }

        try {
          const params: any = {
            fromStation: from,
            toStation: to
          };
          if (isArrival) params['plannedArrivalTime'] = datetime; else params['plannedDepartureTime'] = datetime;

          const res = await api.get('/trip-advices', { params });

          if (!res.data || !res.data.trips) return [];

          return res.data.trips.map((trip: any) => {
            const legs = trip.legs || [];
            const vertrekLeg = legs[0] || {};
            const aankomstLeg = legs[legs.length-1] || {};
            const plannedDuration = trip.plannedDurationInMinutes || 0;

            return {
              vertrekTijd: (vertrekLeg.origin?.plannedDateTime || '').slice(11,16),
              aankomstTijd: (aankomstLeg.destination?.plannedDateTime || '').slice(11,16),
              reistijd: `${Math.floor(plannedDuration/60)}u ${plannedDuration%60}m`,
              overstappen: trip.transfers || 0,
              treinType: vertrekLeg.product?.categoryCode || 'Onbekend',
              perron: vertrekLeg.origin?.plannedTrack || '-',
              tussenstations: legs.slice(0,-1).map((l: any) => l.destination?.name).filter(Boolean),
              prijs: '€ --,--',
              vertrekVertraging: vertrekLeg.origin?.actualDateTime ? Math.floor((new Date(vertrekLeg.origin.actualDateTime).getTime() - new Date(vertrekLeg.origin.plannedDateTime).getTime())/60000) : 0
            } as Route;
          });
        } catch (err) {
          console.error('Error fetching trip advices from NS API', err);
          return [];
        }
      };