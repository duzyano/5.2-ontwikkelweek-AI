export interface Station {
  name: string;
  code: string;
}

export interface Route {
  vertrekTijd: string;
  aankomstTijd: string;
  reistijd: string;
  overstappen: number;
  treinType: string;
  perron: string;
  tussenstations: string[];
  prijs: string;
  vertrekVertraging: number;
}

export interface ApiResponse {
  success: boolean;
  data: any;
  error?: string;
}